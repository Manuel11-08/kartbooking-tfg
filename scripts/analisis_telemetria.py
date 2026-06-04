import os
import sys
import pandas as pd
import matplotlib
matplotlib.use('Agg')  
import matplotlib.pyplot as plt
import matplotlib.patches as mpatches
import mysql.connector
from dotenv import dotenv_values

#  Cargar variables del .env de Laravel 
BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
env = dotenv_values(os.path.join(BASE_DIR, '.env'))


try:
    conn = mysql.connector.connect(
        host=env.get('DB_HOST', '127.0.0.1'),
        port=int(env.get('DB_PORT', 3306)),
        user=env.get('DB_USERNAME', 'root'),
        password=env.get('DB_PASSWORD', ''),
        database=env.get('DB_DATABASE', 'kartbooking')
    )
except Exception as e:
    print(f"Error de conexión a la base de datos: {e}")
    sys.exit(1)

#  Extracción de datos 
query = """
    SELECT
        u.name AS piloto,
        lt.karting_name AS circuito,
        lt.lap_time AS tiempo_vuelta,
        lt.created_at AS fecha
    FROM lap_times lt
    INNER JOIN users u ON u.id = lt.user_id
    WHERE lt.lap_time IS NOT NULL
"""

df = pd.read_sql(query, conn)
conn.close()

#  Transformación y limpieza 
df.dropna(subset=['tiempo_vuelta', 'piloto'], inplace=True)
df['tiempo_vuelta'] = pd.to_numeric(df['tiempo_vuelta'], errors='coerce')
df.dropna(subset=['tiempo_vuelta'], inplace=True)
df = df[df['tiempo_vuelta'] > 0]

if df.empty:
    print("No hay datos de telemetría suficientes para generar el gráfico.")
    sys.exit(0)

# Mejor tiempo por piloto
mejores = (
    df.groupby('piloto')['tiempo_vuelta']
    .min()
    .reset_index()
    .rename(columns={'tiempo_vuelta': 'mejor_tiempo'})
    .sort_values('mejor_tiempo')
    .head(10)  # top 10 pilotos
)


colores = ['#e63946' if i == 0 else '#457b9d' for i in range(len(mejores))]

fig, ax = plt.subplots(figsize=(10, 6))
fig.patch.set_facecolor('#0f172a')
ax.set_facecolor('#1e293b')

bars = ax.barh(
    mejores['piloto'],
    mejores['mejor_tiempo'],
    color=colores,
    edgecolor='none',
    height=0.6
)


for bar, val in zip(bars, mejores['mejor_tiempo']):
    ax.text(
        bar.get_width() + 0.3,
        bar.get_y() + bar.get_height() / 2,
        f'{val:.1f}s',
        va='center', ha='left',
        color='white', fontsize=10, fontweight='bold'
    )

ax.set_xlabel('Tiempo (segundos)', color='#94a3b8', fontsize=11)
ax.set_title('Ranking de Telemetría — Mejores Tiempos por Piloto',
             color='white', fontsize=13, fontweight='bold', pad=15)
ax.tick_params(colors='#94a3b8')
ax.spines[['top', 'right', 'left', 'bottom']].set_visible(False)
ax.xaxis.grid(True, color='#334155', linestyle='--', linewidth=0.5)
ax.set_axisbelow(True)

leyenda = [
    mpatches.Patch(color='#e63946', label='1er puesto'),
    mpatches.Patch(color='#457b9d', label='Resto de pilotos'),
]
ax.legend(handles=leyenda, facecolor='#1e293b', labelcolor='white',
          framealpha=0.8, fontsize=9)

plt.tight_layout()


output_path = os.path.join(BASE_DIR, 'public', 'images', 'telemetria_chart.png')
os.makedirs(os.path.dirname(output_path), exist_ok=True)
plt.savefig(output_path, dpi=150, bbox_inches='tight',
            facecolor=fig.get_facecolor())
plt.close()

print(f"Gráfico generado correctamente en: {output_path}")