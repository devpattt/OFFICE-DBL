<style>
    .dashboard { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .card h2 { margin-bottom: 10px; font-size: 18px; }
    .bar { height: 20px; background-color: #4ade80; margin: 5px 0; }
    .heatmap { display: flex; flex-wrap: wrap; gap: 4px; }
    .day { width: 20px; height: 20px; border-radius: 3px; background-color: #e5e7eb; }
    .count-0 { background-color: #fecaca; } 
    .count-1 { background-color: #fde68a; } 
    .count-2 { background-color: #bbf7d0; } 
    .legend { display: flex; gap: 10px; margin-top: 10px; align-items: center; }
    .legend-item { display: flex; align-items: center; gap: 5px; font-size: 14px; }
    .legend-color { width: 16px; height: 16px; border-radius: 3px; }
    .legend-color.count-0 { background-color: #fecaca; }
    .legend-color.count-1 { background-color: #fde68a; }
    .legend-color.count-2 { background-color: #bbf7d0; }
  </style>

<div class="dashboard">
<div class="card">
  <h2>Weather Info</h2>
  <p>New York, NY</p>
  <p>Light Rain | 16°C</p>
  <p>Wind: 12 km/h | Clouds: 82%</p>
</div>

<div class="card">
  <h2>Weekly Attendance</h2>
  <div>
    <p>2025-04-01</p><div class="bar" style="width: 80%"></div>
    <p>2025-04-02</p><div class="bar" style="width: 75%"></div>
    <p>2025-04-03</p><div class="bar" style="width: 0%"></div>
    <p>2025-04-04</p><div class="bar" style="width: 80%"></div>
    <p>2025-04-05</p><div class="bar" style="width: 70%"></div>
  </div>
</div>

<div class="card">
  <h2>Attendance Trend</h2>
  <p>2025-04-01: 8 hours</p>
  <p>2025-04-02: 7.5 hours</p>
  <p>2025-04-03: 0 hours</p>
  <p>2025-04-04: 8 hours</p>
  <p>2025-04-05: 7 hours</p>
</div>

<div class="card">
  <h2>Punctuality Heatmap</h2>
  <div class="heatmap">
    <div class="day count-1" title="2025-04-01: 1"></div>
    <div class="day count-2" title="2025-04-02: 2"></div>
    <div class="day count-0" title="2025-04-03: 0"></div>
    <div class="day count-1" title="2025-04-04: 1"></div>
    <div class="day count-2" title="2025-04-05: 2"></div>
  </div>
  <div class="legend">
    <div class="legend-item"><div class="legend-color count-0"></div> Very Late (0)</div>
    <div class="legend-item"><div class="legend-color count-1"></div> Slightly Late (1)</div>
    <div class="legend-item"><div class="legend-color count-2"></div> On Time (2)</div>
  </div>
</div>
</div>