<div class="dashboard-page">
    <div class="dashboard-header">
        <h1>ダッシュボード</h1>
        <p class="dashboard-subtitle">同窓会の統計情報</p>
    </div>

    <!-- 統計カード -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: #007cba;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-card-content">
                <h3>全体の人数</h3>
                <p class="stat-number"><?= $totalMembers ?></p>
                <p class="stat-label">名</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon" style="background: #28a745;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="stat-card-content">
                <h3>生存者</h3>
                <p class="stat-number"><?= $aliveCount ?></p>
                <p class="stat-label">名</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon" style="background: #6c757d;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
            </div>
            <div class="stat-card-content">
                <h3>物故者</h3>
                <p class="stat-number"><?= $deceasedCount ?></p>
                <p class="stat-label">名</p>
            </div>
        </div>
    </div>

    <!-- 開催年ごとの参加者数グラフ -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2>開催年ごとの参加者数</h2>
        </div>
        <div class="chart-container">
            <canvas id="attendanceChart"></canvas>
        </div>
    </div>

    <!-- クラス別統計 -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2>クラス別統計</h2>
        </div>
        <div class="class-stats-grid">
            <?php foreach ($membersByClass as $classStat): ?>
                <?php
                // 該当クラスの物故者数を取得
                $classDeceasedCount = 0;
                foreach ($deceasedByClass as $deceasedStat) {
                    if ($deceasedStat->class == $classStat->class) {
                        $classDeceasedCount = $deceasedStat->count;
                        break;
                    }
                }
                // 2023年の出席数
                $classAttendance2023 = $attendance2023ByClass[$classStat->class] ?? 0;
                ?>
                <div class="class-stat-card">
                    <h3><?= h($classStat->class) ?>組</h3>
                    <div class="class-stat-details">
                        <div class="class-stat-item">
                            <span class="class-stat-label">合計人数</span>
                            <span class="class-stat-value"><?= $classStat->count ?>名</span>
                        </div>
                        <div class="class-stat-item">
                            <span class="class-stat-label">2023年出席</span>
                            <span class="class-stat-value"><?= $classAttendance2023 ?>名</span>
                        </div>
                        <div class="class-stat-item">
                            <span class="class-stat-label">物故者</span>
                            <span class="class-stat-value"><?= $classDeceasedCount ?>名</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
$this->start('script');
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    
    const years = <?= json_encode($years) ?>;
    const maleCounts = <?= json_encode($maleCounts) ?>;
    const femaleCounts = <?= json_encode($femaleCounts) ?>;
    const totalCounts = <?= json_encode($totalCounts) ?>;
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: years,
            datasets: [{
                label: '男性',
                data: maleCounts,
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }, {
                label: '女性',
                data: femaleCounts,
                backgroundColor: 'rgba(255, 99, 132, 0.8)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }, {
                label: '全体',
                data: totalCounts,
                backgroundColor: 'rgba(153, 102, 255, 0.8)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 16
                    },
                    bodyFont: {
                        size: 14
                    },
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + '名';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 12
                        },
                        callback: function(value) {
                            return value + '名';
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
<?php
$this->end();
?>

<?php
$this->start('css');
?>
<style>
.dashboard-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.dashboard-header {
    text-align: center;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid #e9ecef;
}

.dashboard-header h1 {
    color: #007cba;
    font-size: 2.5rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.dashboard-subtitle {
    color: #666;
    font-size: 1.1rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.stat-card {
    background: #fff;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e9ecef;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.stat-card-icon {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.stat-card-content {
    flex: 1;
}

.stat-card-content h3 {
    color: #333;
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #007cba;
    margin: 0;
    line-height: 1;
}

.stat-label {
    color: #666;
    font-size: 0.9rem;
    margin-top: 0.25rem;
    margin-bottom: 0;
}

.dashboard-section {
    background: #fff;
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
}

.section-header {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e9ecef;
}

.section-header h2 {
    color: #007cba;
    font-size: 1.75rem;
    font-weight: 600;
    margin: 0;
}

.chart-container {
    position: relative;
    height: 400px;
    width: 100%;
}

.class-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1.5rem;
}

.class-stat-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1.5rem;
    border: 1px solid #e9ecef;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.class-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.class-stat-card h3 {
    color: #007cba;
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    text-align: center;
    border-bottom: 2px solid #007cba;
    padding-bottom: 0.5rem;
}

.class-stat-details {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.class-stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
}

.class-stat-label {
    color: #666;
    font-size: 1.2rem;
    font-weight: 500;
}

.class-stat-value {
    color: #333;
    font-size: 1.1rem;
    font-weight: 600;
}

@media (max-width: 768px) {
    .dashboard-page {
        padding: 1rem 0.5rem;
    }

    .dashboard-header h1 {
        font-size: 2rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .dashboard-section {
        padding: 1.5rem;
    }

    .chart-container {
        height: 300px;
    }

    .class-stats-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
    }

    .class-stat-card {
        padding: 1rem;
    }
}

@media (max-width: 480px) {
    .dashboard-header h1 {
        font-size: 1.75rem;
    }

    .stat-card {
        flex-direction: column;
        text-align: center;
        padding: 1.5rem;
    }

    .stat-card-icon {
        width: 56px;
        height: 56px;
    }

    .stat-number {
        font-size: 2rem;
    }

    .class-stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<?php
$this->end();
?>

