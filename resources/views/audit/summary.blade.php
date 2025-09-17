@extends('layouts.admin')

@section('title', 'Đánh Giá Nội Bộ - Tổng Hợp')

@section('content')
<div class="container audit-dashboard">
    <div class="page-header">
        <h1 class="page-header__title">ĐÁNH GIÁ NỘI BỘ - TỔNG HỢP</h1>
        <div class="page-header__breadcrumb">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span class="breadcrumb-separator">></span>
            <a href="{{ route('admin.audit.summary') }}">Đánh giá nội bộ</a>
            <span class="breadcrumb-separator">></span>
            <span>Tổng hợp</span>
        </div>
    </div>

    <div class="content-layout">
        <!-- Main Content -->
        <div class="content-layout__main">
            <!-- Statistics Overview -->
            <div class="stats-overview">
                <div class="stats-grid">
                    <div class="stats-card">
                        <div class="stats-card__icon">📊</div>
                        <div class="stats-card__content">
                            <h3 class="stats-card__title">Tổng số</h3>
                            <p class="stats-card__value">14</p>
                            <p class="stats-card__subtitle">Tính đến hết năm 2025</p>
                        </div>
                    </div>

                    <div class="stats-card">
                        <div class="stats-card__icon">✅</div>
                        <div class="stats-card__content">
                            <h3 class="stats-card__title">Đã hoàn thành</h3>
                            <p class="stats-card__value">12</p>
                        </div>
                    </div>

                    <div class="stats-card">
                        <div class="stats-card__icon">🔄</div>
                        <div class="stats-card__content">
                            <h3 class="stats-card__title">Đang thực hiện</h3>
                            <p class="stats-card__value">1</p>
                            <p class="stats-card__subtitle">đạt 75%</p>
                        </div>
                    </div>

                    <div class="stats-card">
                        <div class="stats-card__icon">⏳</div>
                        <div class="stats-card__content">
                            <h3 class="stats-card__title">Chưa bắt đầu</h3>
                            <p class="stats-card__value">1</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-section">
                <!-- Pie Chart - Findings Distribution -->
                <div class="chart-container">
                    <div class="chart-header">
                        <h3>Tổng hợp kết quả đánh giá</h3>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="findingsChart" class="pie-chart"></canvas>
                    </div>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <span class="legend-color legend-color--compliant"></span>
                            <span class="legend-label">Phù hợp:</span>
                            <span class="legend-value">45</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color legend-color--non-compliant"></span>
                            <span class="legend-label">Không phù hợp:</span>
                            <span class="legend-value">12</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color legend-color--opportunity"></span>
                            <span class="legend-label">Cơ hội cải tiến:</span>
                            <span class="legend-value">8</span>
                        </div>
                    </div>
                </div>

                <!-- Bar Chart - Monthly Progress -->
                <div class="chart-container">
                    <div class="chart-header">
                        <h3>Tiến độ đánh giá theo tháng</h3>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="progressChart" class="bar-chart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Progress Section -->
            <div class="progress-section">
                <h3>Tiến độ từng đợt đánh giá</h3>
                <div class="audit-progress-list">
                    <div class="progress-item">
                        <div class="progress-header">
                            <h4 class="progress-title">Đánh giá nội bộ Phòng Kế hoạch</h4>
                            <span class="progress-percentage">100%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-fill--completed" style="width: 100%"></div>
                        </div>
                        <div class="progress-details">
                            <div class="progress-dates">
                                <span>Bắt đầu: 8h00 ngày 05/01/2025</span>
                                <span>Kết thúc: 17h00 ngày 05/01/2025</span>
                            </div>
                            <span class="progress-status status--completed">Hoàn thành</span>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <h4 class="progress-title">Đánh giá nội bộ Phòng KCS</h4>
                            <span class="progress-percentage">85%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-fill--in-progress" style="width: 85%"></div>
                        </div>
                        <div class="progress-details">
                            <div class="progress-dates">
                                <span>Bắt đầu: 7h30 ngày 08/01/2025</span>
                                <span>Kết thúc: 16h30 ngày 08/01/2025</span>
                            </div>
                            <span class="progress-status status--in-progress">Đang thực hiện</span>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <h4 class="progress-title">Đánh giá nội bộ Phòng Tài chính</h4>
                            <span class="progress-percentage">100%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-fill--completed" style="width: 100%"></div>
                        </div>
                        <div class="progress-details">
                            <div class="progress-dates">
                                <span>Bắt đầu: 9h00 ngày 10/01/2025</span>
                                <span>Kết thúc: 15h00 ngày 10/01/2025</span>
                            </div>
                            <span class="progress-status status--completed">Hoàn thành</span>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <h4 class="progress-title">Đánh giá nội bộ Phòng Cơ điện</h4>
                            <span class="progress-percentage">60%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-fill--in-progress" style="width: 60%"></div>
                        </div>
                        <div class="progress-details">
                            <div class="progress-dates">
                                <span>Bắt đầu: 8h00 ngày 12/01/2025</span>
                                <span>Kết thúc: 17h00 ngày 12/01/2025</span>
                            </div>
                            <span class="progress-status status--in-progress">Đang thực hiện</span>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <h4 class="progress-title">Đánh giá nội bộ Phòng Hành chính-Hậu cần</h4>
                            <span class="progress-percentage">100%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-fill--completed" style="width: 100%"></div>
                        </div>
                        <div class="progress-details">
                            <div class="progress-dates">
                                <span>Bắt đầu: 7h00 ngày 15/01/2025</span>
                                <span>Kết thúc: 16h00 ngày 15/01/2025</span>
                            </div>
                            <span class="progress-status status--completed">Hoàn thành</span>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <h4 class="progress-title">Đánh giá nội bộ Phòng Vật tư</h4>
                            <span class="progress-percentage">40%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-fill--in-progress" style="width: 40%"></div>
                        </div>
                        <div class="progress-details">
                            <div class="progress-dates">
                                <span>Bắt đầu: 8h30 ngày 18/01/2025</span>
                                <span>Kết thúc: 16h30 ngày 18/01/2025</span>
                            </div>
                            <span class="progress-status status--in-progress">Đang thực hiện</span>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <h4 class="progress-title">Đánh giá nội bộ Ban Chính trị</h4>
                            <span class="progress-percentage">20%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-fill--pending" style="width: 20%"></div>
                        </div>
                        <div class="progress-details">
                            <div class="progress-dates">
                                <span>Bắt đầu: 9h00 ngày 20/01/2025</span>
                                <span>Kết thúc: 15h00 ngày 20/01/2025</span>
                            </div>
                            <span class="progress-status status--pending">Chờ thực hiện</span>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <h4 class="progress-title">Đánh giá nội bộ Phân xưởng 1</h4>
                            <span class="progress-percentage">90%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-fill--in-progress" style="width: 90%"></div>
                        </div>
                        <div class="progress-details">
                            <div class="progress-dates">
                                <span>Bắt đầu: 6h30 ngày 22/01/2025</span>
                                <span>Kết thúc: 14h30 ngày 22/01/2025</span>
                            </div>
                            <span class="progress-status status--in-progress">Đang thực hiện</span>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <h4 class="progress-title">Đánh giá nội bộ Phân xưởng 2</h4>
                            <span class="progress-percentage">75%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-fill--in-progress" style="width: 75%"></div>
                        </div>
                        <div class="progress-details">
                            <div class="progress-dates">
                                <span>Bắt đầu: 7h00 ngày 25/01/2025</span>
                                <span>Kết thúc: 15h00 ngày 25/01/2025</span>
                            </div>
                            <span class="progress-status status--in-progress">Đang thực hiện</span>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <h4 class="progress-title">Đánh giá nội bộ Phân xưởng 3</h4>
                            <span class="progress-percentage">100%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-fill--completed" style="width: 100%"></div>
                        </div>
                        <div class="progress-details">
                            <div class="progress-dates">
                                <span>Bắt đầu: 6h00 ngày 28/01/2025</span>
                                <span>Kết thúc: 14h00 ngày 28/01/2025</span>
                            </div>
                            <span class="progress-status status--completed">Hoàn thành</span>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <h4 class="progress-title">Đánh giá nội bộ Phân xưởng 4</h4>
                            <span class="progress-percentage">50%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-fill--overdue" style="width: 50%"></div>
                        </div>
                        <div class="progress-details">
                            <div class="progress-dates">
                                <span>Bắt đầu: 7h30 ngày 30/01/2025</span>
                                <span>Kết thúc: 15h30 ngày 30/01/2025</span>
                            </div>
                            <span class="progress-status status--overdue">Quá hạn</span>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <h4 class="progress-title">Đánh giá nội bộ Phân xưởng 5</h4>
                            <span class="progress-percentage">30%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-fill--pending" style="width: 30%"></div>
                        </div>
                        <div class="progress-details">
                            <div class="progress-dates">
                                <span>Bắt đầu: 8h00 ngày 02/02/2025</span>
                                <span>Kết thúc: 16h00 ngày 02/02/2025</span>
                            </div>
                            <span class="progress-status status--pending">Chờ thực hiện</span>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <h4 class="progress-title">Đánh giá nội bộ Phân xưởng 6</h4>
                            <span class="progress-percentage">80%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-fill--in-progress" style="width: 80%"></div>
                        </div>
                        <div class="progress-details">
                            <div class="progress-dates">
                                <span>Bắt đầu: 6h30 ngày 05/02/2025</span>
                                <span>Kết thúc: 14h30 ngày 05/02/2025</span>
                            </div>
                            <span class="progress-status status--in-progress">Đang thực hiện</span>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <h4 class="progress-title">Đánh giá nội bộ Phân xưởng 7</h4>
                            <span class="progress-percentage">65%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-fill--in-progress" style="width: 65%"></div>
                        </div>
                        <div class="progress-details">
                            <div class="progress-dates">
                                <span>Bắt đầu: 7h00 ngày 08/02/2025</span>
                                <span>Kết thúc: 15h00 ngày 08/02/2025</span>
                            </div>
                            <span class="progress-status status--in-progress">Đang thực hiện</span>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <h4 class="progress-title">Đánh giá nội bộ Phân xưởng 8</h4>
                            <span class="progress-percentage">100%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-fill--completed" style="width: 100%"></div>
                        </div>
                        <div class="progress-details">
                            <div class="progress-dates">
                                <span>Bắt đầu: 6h00 ngày 10/02/2025</span>
                                <span>Kết thúc: 14h00 ngày 10/02/2025</span>
                            </div>
                            <span class="progress-status status--completed">Hoàn thành</span>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <h4 class="progress-title">Đánh giá nội bộ Phân xưởng 9</h4>
                            <span class="progress-percentage">45%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-fill--overdue" style="width: 45%"></div>
                        </div>
                        <div class="progress-details">
                            <div class="progress-dates">
                                <span>Bắt đầu: 7h30 ngày 12/02/2025</span>
                                <span>Kết thúc: 15h30 ngày 12/02/2025</span>
                            </div>
                            <span class="progress-status status--overdue">Quá hạn</span>
                        </div>
                    </div>

                    <div class="progress-item">
                        <div class="progress-header">
                            <h4 class="progress-title">Đánh giá nội bộ Trạm O</h4>
                            <span class="progress-percentage">10%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-fill--pending" style="width: 10%"></div>
                        </div>
                        <div class="progress-details">
                            <div class="progress-dates">
                                <span>Bắt đầu: 8h00 ngày 15/02/2025</span>
                                <span>Kết thúc: 16h00 ngày 15/02/2025</span>
                            </div>
                            <span class="progress-status status--pending">Chờ thực hiện</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <!-- <section class="sidebar-section">
            <h3 class="sidebar-section__title">Truy cập nhanh</h3>
            <div class="quick-links">
                <a href="{{ route('admin.audit.program') }}" class="quick-link">
                    <span class="quick-link__icon">📋</span>
                    <span class="quick-link__text">Chương trình đánh giá</span>
                </a>
                <a href="{{ route('admin.audit.implementation') }}" class="quick-link">
                    <span class="quick-link__icon">⚡</span>
                    <span class="quick-link__text">Thực hiện đánh giá</span>
                </a>
                <a href="{{ route('admin.audit.report') }}" class="quick-link">
                    <span class="quick-link__icon">📄</span>
                    <span class="quick-link__text">Báo cáo</span>
                </a>
                <a href="{{ route('admin.audit.action') }}" class="quick-link">
                    <span class="quick-link__icon">🔧</span>
                    <span class="quick-link__text">Hành động khắc phục</span>
                </a>
            </div>
        </section> -->

        <!-- Calendar -->
        <!-- <section class="sidebar-section">
            <h3 class="sidebar-section__title">Lịch đánh giá</h3>
            <div class="calendar-widget">
                <div class="calendar-event">
                    <div class="calendar-event__date">20/12/2024</div>
                    <div class="calendar-event__title">Đánh giá Phòng QLCL</div>
                </div>
                <div class="calendar-event">
                    <div class="calendar-event__date">25/12/2024</div>
                    <div class="calendar-event__title">Đánh giá Phòng KHCN</div>
                </div>
                <div class="calendar-event">
                    <div class="calendar-event__date">30/12/2024</div>
                    <div class="calendar-event__title">Tổng kết năm 2024</div>
                </div>
            </div>
        </section> -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pie Chart - Findings Distribution
    const findingsCtx = document.getElementById('findingsChart').getContext('2d');
    const findingsChart = new Chart(findingsCtx, {
        type: 'pie',
        data: {
            labels: ['Phù hợp', 'Không phù hợp', 'Cơ hội cải tiến'],
            datasets: [{
                data: [45, 12, 8],
                backgroundColor: [
                    '#059669', // Green for compliant
                    '#dc2626', // Red for non-compliant
                    '#3b82f6'  // Blue for opportunity
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // We use custom legend
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((context.parsed / total) * 100);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Bar Chart - Yearly Results
    const progressCtx = document.getElementById('progressChart').getContext('2d');
    const progressChart = new Chart(progressCtx, {
        type: 'bar',
        data: {
            labels: ['Năm 2022', 'Năm 2023', 'Năm 2024', 'Năm 2025'],
            datasets: [{
                label: 'Phù hợp',
                data: [15, 18, 22, 25],
                backgroundColor: '#059669',
                borderColor: '#059669',
                borderWidth: 1
            }, {
                label: 'Không phù hợp',
                data: [8, 6, 4, 3],
                backgroundColor: '#dc2626',
                borderColor: '#dc2626',
                borderWidth: 1
            }, {
                label: 'Cơ hội cải tiến',
                data: [5, 7, 6, 8],
                backgroundColor: '#3b82f6',
                borderColor: '#3b82f6',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            }
        }
    });
});
</script>
@endsection