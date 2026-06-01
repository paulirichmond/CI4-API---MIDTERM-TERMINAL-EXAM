<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $user = session('user'); $firstName = explode(' ', $user['fullname'] ?? 'User')[0]; ?>

<!-- Page Head -->
<div class="page-head">
    <div>
        <h1>Dashboard</h1>
        <p>Good <?= date('H') < 12 ? 'morning' : (date('H') < 17 ? 'afternoon' : 'evening') ?>, <?= esc($firstName) ?>. Here's what's happening at Digimon Academy.</p>
    </div>
    <div class="page-head-actions">
        <a href="<?= base_url('students') ?>" class="btn btn-primary">
            <i class="bi bi-people-fill"></i> View Students
        </a>
    </div>
</div>

<!-- KPI Cards -->
<div class="kpi-row">
    <div class="kpi kpi-indigo">
        <div class="kpi-icon-wrap"><i class="bi bi-people-fill"></i></div>
        <div class="kpi-body">
            <div class="kpi-val"><?= number_format($totalStudents) ?></div>
            <div class="kpi-lbl">Total Students</div>
        </div>
        <div class="kpi-chart-mini" id="spark-1"></div>
    </div>
    <div class="kpi kpi-emerald">
        <div class="kpi-icon-wrap"><i class="bi bi-person-check-fill"></i></div>
        <div class="kpi-body">
            <div class="kpi-val"><?= number_format($activeToday) ?></div>
            <div class="kpi-lbl">Active Today</div>
        </div>
        <div class="kpi-chart-mini" id="spark-2"></div>
    </div>
    <div class="kpi kpi-violet">
        <div class="kpi-icon-wrap"><i class="bi bi-person-plus-fill"></i></div>
        <div class="kpi-body">
            <div class="kpi-val"><?= number_format($newThisMonth) ?></div>
            <div class="kpi-lbl">New This Month</div>
        </div>
        <div class="kpi-chart-mini" id="spark-3"></div>
    </div>
    <div class="kpi kpi-sky">
        <div class="kpi-icon-wrap"><i class="bi bi-mortarboard-fill"></i></div>
        <div class="kpi-body">
            <div class="kpi-val"><?= number_format($courses) ?></div>
            <div class="kpi-lbl">Courses Offered</div>
        </div>
        <div class="kpi-chart-mini" id="spark-4"></div>
    </div>
</div>

<!-- Main Grid -->
<div class="dash-grid">

    <!-- Area Chart -->
    <div class="card dash-main">
        <div class="card-header">
            <div class="card-title">
                <i class="bi bi-graph-up-arrow" style="color:var(--indigo);"></i>
                Enrollment Trend
            </div>
            <div style="display:flex;gap:4px;">
                <button class="btn btn-xs chart-tab" data-tab="weekly" onclick="switchChart('weekly')">Weekly</button>
                <button class="btn btn-xs chart-tab active" data-tab="monthly" onclick="switchChart('monthly')">Monthly</button>
                <button class="btn btn-xs chart-tab" data-tab="yearly" onclick="switchChart('yearly')">Yearly</button>
            </div>
        </div>
        <div class="card-body" style="padding:8px 16px 12px;">
            <div id="chart-area"></div>
        </div>
    </div>

    <!-- Donut + Breakdown -->
    <div class="card dash-side">
        <div class="card-header">
            <div class="card-title"><i class="bi bi-pie-chart-fill" style="color:var(--indigo);"></i> User Roles</div>
        </div>
        <div class="card-body">
            <div id="chart-donut"></div>
            <div class="role-breakdown">
                <?php foreach ([
                    ['Students',     '#6366f1', $totalStudents],
                    ['Teachers',     '#059669', $countTeachers],
                    ['Coordinators', '#b45309', $countCoords],
                    ['Admins',       '#0284c7', $countAdmins],
                ] as [$label, $color, $count]): ?>
                <div class="role-row">
                    <span class="role-dot" style="background:<?= $color ?>;"></span>
                    <span class="role-name"><?= $label ?></span>
                    <span class="role-count"><?= $count ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <div style="margin-top:16px;display:flex;flex-direction:column;gap:6px;">
                <a href="<?= base_url('students') ?>" class="btn btn-secondary btn-sm" style="justify-content:flex-start;">
                    <i class="bi bi-people"></i> All Students
                </a>
                <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary btn-sm" style="justify-content:flex-start;">
                    <i class="bi bi-person-badge"></i> Manage Users
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Students -->
    <div class="card dash-table">
        <div class="card-header">
            <div class="card-title"><i class="bi bi-clock-history" style="color:var(--indigo);"></i> Recently Enrolled</div>
            <a href="<?= base_url('students') ?>" class="btn btn-ghost btn-xs">View all <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="data-table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Enrolled</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentStudents ?? [])): ?>
                    <tr><td colspan="5" style="text-align:center;padding:32px;color:var(--text-3);">
                        <i class="bi bi-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                        No students enrolled yet
                    </td></tr>
                    <?php else: ?>
                    <?php foreach (($recentStudents ?? []) as $s): ?>
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <?= strtoupper(substr($s['fullname'] ?? 'U', 0, 1)) ?>
                                </div>
                                <div>
                                    <div style="font-weight:700;font-size:13px;"><?= esc($s['fullname']) ?></div>
                                    <div style="font-size:11px;color:var(--text-3);"><?= esc($s['username']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-indigo"><?= esc($s['course'] ?? '—') ?></span></td>
                        <td style="color:var(--text-2);"><?= $s['year_level'] ? 'Year '.$s['year_level'] : '—' ?></td>
                        <td style="color:var(--text-3);font-size:12px;"><?= date('M d, Y', strtotime($s['created_at'])) ?></td>
                        <td><a href="<?= base_url('students/show/'.$s['id']) ?>" class="btn btn-ghost btn-xs"><i class="bi bi-eye"></i></a></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="card dash-quick">
        <div class="card-header">
            <div class="card-title"><i class="bi bi-lightning-charge-fill" style="color:var(--indigo);"></i> Quick Stats</div>
        </div>
        <div class="card-body" style="display:flex;flex-direction:column;gap:14px;">
            <?php
            $stats = [
                ['Total Accounts',  $totalStudents + $countTeachers + $countCoords + $countAdmins, 'bi-people',        '#6366f1'],
                ['Students',        $totalStudents,     'bi-mortarboard',   '#8b5cf6'],
                ['Staff Members',   $countTeachers + $countCoords + $countAdmins, 'bi-person-badge',  '#059669'],
                ['Courses Active',  $courses,           'bi-book',          '#0284c7'],
            ];
            foreach ($stats as [$lbl, $val, $ico, $clr]):
            ?>
            <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;background:var(--bg);border-radius:10px;">
                <div style="width:34px;height:34px;border-radius:8px;background:<?= $clr ?>18;display:flex;align-items:center;justify-content:center;color:<?= $clr ?>;font-size:15px;flex-shrink:0;">
                    <i class="bi <?= $ico ?>"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-size:11px;color:var(--text-3);font-weight:600;"><?= $lbl ?></div>
                </div>
                <div style="font-size:18px;font-weight:800;color:var(--text-1);"><?= $val ?></div>
            </div>
            <?php endforeach; ?>

            <div style="margin-top:4px;padding-top:14px;border-top:1px solid var(--border);">
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text-3);margin-bottom:10px;">System Info</div>
                <div style="display:flex;flex-direction:column;gap:6px;">
                    <div style="display:flex;justify-content:space-between;font-size:12px;">
                        <span style="color:var(--text-3);">Environment</span>
                        <span class="badge badge-emerald"><?= ucfirst(ENVIRONMENT) ?></span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:12px;">
                        <span style="color:var(--text-3);">PHP Version</span>
                        <span style="font-weight:600;color:var(--text-1);"><?= PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION ?></span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:12px;">
                        <span style="color:var(--text-3);">Date</span>
                        <span style="font-weight:600;color:var(--text-1);">Apr 09, 2025</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" crossorigin="anonymous"></script>
<script>
const C = { indigo:'#6366f1', violet:'#8b5cf6', emerald:'#059669', sky:'#0284c7', amber:'#b45309', border:'#e2e8f0', text3:'#94a3b8' };
const font = 'Plus Jakarta Sans, sans-serif';

// Sparklines
[
  { id:'spark-1', color:C.indigo,   data:[3,5,4,7,6,8,<?= $totalStudents ?>] },
  { id:'spark-2', color:C.emerald,  data:[1,2,1,3,2,4,<?= $activeToday ?>] },
  { id:'spark-3', color:C.violet,   data:[0,1,0,2,1,3,<?= $newThisMonth ?>] },
  { id:'spark-4', color:C.sky,      data:[1,1,2,2,3,3,<?= $courses ?>] },
].forEach(s => {
  new ApexCharts(document.getElementById(s.id), {
    series:[{data:s.data}],
    chart:{type:'area',height:48,sparkline:{enabled:true},background:'transparent'},
    stroke:{curve:'smooth',width:2},
    fill:{type:'gradient',gradient:{shadeIntensity:1,opacityFrom:.3,opacityTo:0}},
    colors:[s.color], tooltip:{enabled:false}
  }).render();
});

// Area Chart
const chartData = {
  weekly:  { cats:['Mon','Tue','Wed','Thu','Fri','Sat','Sun'], enrolled:[1,2,1,3,2,4,<?= $totalStudents ?>], new:[0,1,0,1,1,2,<?= $newThisMonth ?>] },
  monthly: { cats:['Jan','Feb','Mar','Apr','May','Jun','<?= date('M') ?>'], enrolled:[2,3,4,5,4,6,<?= $totalStudents ?>], new:[1,1,2,2,1,3,<?= $newThisMonth ?>] },
  yearly:  { cats:['2020','2021','2022','2023','2024','2025','2026'], enrolled:[1,2,3,4,5,6,<?= $totalStudents ?>], new:[0,1,1,2,2,3,<?= $newThisMonth ?>] },
};

const areaChart = new ApexCharts(document.querySelector('#chart-area'), {
  series:[
    {name:'Enrolled', data: chartData.monthly.enrolled},
    {name:'New',      data: chartData.monthly.new}
  ],
  chart:{height:220,type:'area',toolbar:{show:false},fontFamily:font,background:'transparent',id:'areaChart'},
    colors:[C.indigo, C.emerald],
  stroke:{curve:'smooth',width:2},
  fill:{type:'gradient',gradient:{shadeIntensity:1,opacityFrom:.15,opacityTo:0.02}},
  dataLabels:{enabled:false},
  xaxis:{
    categories: chartData.monthly.cats,
    axisBorder:{show:false},axisTicks:{show:false},
    labels:{style:{colors:C.text3,fontSize:'11px',fontFamily:font}}
  },
  yaxis:{labels:{style:{colors:C.text3,fontSize:'11px',fontFamily:font}}},
  grid:{borderColor:C.border,strokeDashArray:4,padding:{left:0,right:0,top:-10}},
  legend:{position:'top',horizontalAlign:'right',fontSize:'12px',fontWeight:600,fontFamily:font,markers:{radius:3,width:10,height:10}},
  tooltip:{style:{fontSize:'12px',fontFamily:font}}
});
areaChart.render();

function switchChart(tab) {
  const d = chartData[tab];
  areaChart.updateOptions({ xaxis:{ categories: d.cats } });
  areaChart.updateSeries([
    {name:'Enrolled', data: d.enrolled},
    {name:'New',      data: d.new}
  ]);
  document.querySelectorAll('.chart-tab').forEach(b => {
    b.classList.toggle('active', b.dataset.tab === tab);
  });
}

// Donut
new ApexCharts(document.querySelector('#chart-donut'), {
  series:[<?= $totalStudents ?>, <?= $countTeachers ?>, <?= $countCoords ?>, <?= $countAdmins ?>],
  chart:{height:180,type:'donut',fontFamily:font,background:'transparent'},
  colors:[C.indigo, C.emerald, C.amber, C.sky],
  labels:['Students','Teachers','Coordinators','Admins'],
  dataLabels:{enabled:false},
  legend:{show:false},
  stroke:{show:true,colors:['#ffffff'],width:3},
  plotOptions:{pie:{donut:{size:'70%',labels:{show:true,
    total:{show:true,showAlways:true,label:'Total',fontSize:'11px',fontFamily:font,color:C.text3,
      formatter:()=>'<?= $totalStudents + $countTeachers + $countCoords + $countAdmins ?>'},
    value:{show:true,fontSize:'20px',fontWeight:800,color:'#0f172a',fontFamily:font}
  }}}},
  tooltip:{style:{fontSize:'12px',fontFamily:font}}
}).render();
</script>
<?= $this->endSection() ?>
