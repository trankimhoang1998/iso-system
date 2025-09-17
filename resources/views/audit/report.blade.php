@extends('layouts.admin')

@section('title', 'Đánh Giá Nội Bộ - Báo Cáo & Kết Quả')

@section('content')
<div class="container audit-report">
    <div class="page-header">
        <h1 class="page-header__title">BÁO CÁO & KẾT QUẢ ĐÁNH GIÁ</h1>
        <div class="page-header__breadcrumb">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span class="breadcrumb-separator">></span>
            <a href="{{ route('admin.audit.summary') }}">Đánh giá nội bộ</a>
            <span class="breadcrumb-separator">></span>
            <span>Báo cáo</span>
        </div>
    </div>

    <!-- Report Summary -->
    <div class="section">
        <div class="section__header">
            <h2 class="section__title">Tổng quan báo cáo đánh giá</h2>
            <div class="section__actions">
                <div class="export-buttons">
                    <button type="button" class="btn btn-outline btn-export" data-format="pdf">
                        <span class="btn-icon">📄</span>
                        Tải PDF
                    </button>
                    <button type="button" class="btn btn-outline btn-export" data-format="word">
                        <span class="btn-icon">📝</span>
                        Tải Word
                    </button>
                    <button type="button" class="btn btn-primary" data-modal-target="create-report-modal">
                        <span class="btn-icon">📊</span>
                        Tạo báo cáo đánh giá mới
                    </button>
                </div>
            </div>
        </div>

        <div class="report-overview">
            <div class="overview-grid">
                <div class="overview-card">
                    <div class="overview-card__header">
                        <h3 class="overview-card__title">Thông tin chung</h3>
                    </div>
                    <div class="overview-card__content">
                        <div class="info-row">
                            <span class="info-label">Bộ phận:</span>
                            <span class="info-value">Phòng Kỹ thuật</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Thời gian:</span>
                            <span class="info-value">7h30 - 17h00 ngày 16/5/2025</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tổ đánh giá:</span>
                            <span class="info-value">Đinh Quang Điềm; Tạ Hồng Đăng; Đỗ Văn Quân</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tiêu chuẩn:</span>
                            <span class="info-value">ISO 9001:2015</span>
                        </div>
                    </div>
                </div>

                <div class="overview-card">
                    <div class="overview-card__header">
                        <h3 class="overview-card__title">Kết quả tổng quan</h3>
                    </div>
                    <div class="overview-card__content">
                        <div class="result-stats">
                            <div class="result-stat result-stat--compliant">
                                <span class="result-stat__value">18</span>
                                <span class="result-stat__label">Phù hợp</span>
                            </div>
                            <div class="result-stat result-stat--non-compliant">
                                <span class="result-stat__value">3</span>
                                <span class="result-stat__label">Không phù hợp</span>
                            </div>
                            <div class="result-stat result-stat--opportunity">
                                <span class="result-stat__value">4</span>
                                <span class="result-stat__label">Cơ hội cải tiến</span>
                            </div>
                        </div>
                        <div class="compliance-percentage">
                            <div class="percentage-bar">
                                <div class="percentage-fill" style="width: 72%"></div>
                            </div>
                            <span class="percentage-text">72% Phù hợp</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Results Table -->
    <div class="section">
        <div class="section__header">
            <h3 class="section__title">Chi tiết kết quả đánh giá</h3>
            <div class="section__filters">
                <select class="form-select form-select--compact">
                    <option value="">Tất cả trạng thái</option>
                    <option value="compliant">Phù hợp</option>
                    <option value="non-compliant">Không phù hợp</option>
                    <option value="opportunity">Cơ hội cải tiến</option>
                </select>
                <select class="form-select form-select--compact">
                    <option value="">Tất cả điều khoản</option>
                    <option value="4">4. Bối cảnh tổ chức</option>
                    <option value="5">5. Lãnh đạo</option>
                    <option value="6">6. Hoạch định</option>
                    <option value="7">7. Hỗ trợ</option>
                    <option value="8">8. Hoạt động</option>
                    <option value="9">9. Đánh giá hiệu năng</option>
                    <option value="10">10. Cải tiến</option>
                </select>
            </div>
        </div>

        <div class="report-table-container">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Tiêu chí</th>
                        <th>Kết quả</th>
                        <th>Bằng chứng</th>
                        <th>Ghi chú</th>
                        <th>Trạng thái khắc phục</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-row" data-status="compliant">
                        <td class="criteria-cell">
                            <div class="criteria-code">4.1</div>
                            <div class="criteria-text">Hiểu rõ tổ chức và bối cảnh của nó</div>
                        </td>
                        <td class="result-cell">
                            <span class="result-badge result-badge--compliant">✅ Phù hợp</span>
                        </td>
                        <td class="evidence-cell">
                            <div class="evidence-list">
                                <span class="evidence-item">📄 Context_Analysis_2024.pdf</span>
                            </div>
                        </td>
                        <td class="notes-cell">
                            <div class="notes-text">Tổ chức đã xác định được bối cảnh hoạt động rõ ràng.</div>
                        </td>
                        <td class="remediation-cell">
                            <span class="remediation-status remediation-status--not-required">Không cần</span>
                        </td>
                        <td class="actions-cell">
                            <button class="btn-action btn-action--view" title="Xem chi tiết">👁️</button>
                            <button class="btn-action btn-action--edit" title="Chỉnh sửa">✏️</button>
                        </td>
                    </tr>

                    <tr class="table-row" data-status="non-compliant">
                        <td class="criteria-cell">
                            <div class="criteria-code">4.3</div>
                            <div class="criteria-text">Xác định phạm vi của hệ thống quản lý chất lượng</div>
                        </td>
                        <td class="result-cell">
                            <span class="result-badge result-badge--non-compliant">❌ Không phù hợp</span>
                        </td>
                        <td class="evidence-cell">
                            <div class="evidence-list">
                                <span class="evidence-item">📸 QMS_Scope_Issues.jpg</span>
                            </div>
                        </td>
                        <td class="notes-cell">
                            <div class="notes-text">Phạm vi QMS chưa được mô tả đầy đủ. Thiếu thông tin về các quy trình ngoại vi.</div>
                        </td>
                        <td class="remediation-cell">
                            <span class="remediation-status remediation-status--pending">Đang xử lý</span>
                            <div class="remediation-deadline">Hạn: 15/01/2025</div>
                        </td>
                        <td class="actions-cell">
                            <button class="btn-action btn-action--view" title="Xem chi tiết">👁️</button>
                            <button class="btn-action btn-action--edit" title="Chỉnh sửa">✏️</button>
                            <button class="btn-action btn-action--remediate" title="Khắc phục">🔧</button>
                        </td>
                    </tr>

                    <tr class="table-row" data-status="opportunity">
                        <td class="criteria-cell">
                            <div class="criteria-code">5.1</div>
                            <div class="criteria-text">Lãnh đạo và cam kết</div>
                        </td>
                        <td class="result-cell">
                            <span class="result-badge result-badge--opportunity">⚠️ Cơ hội cải tiến</span>
                        </td>
                        <td class="evidence-cell">
                            <div class="evidence-list">
                                <span class="evidence-item">📄 Leadership_Review.pdf</span>
                            </div>
                        </td>
                        <td class="notes-cell">
                            <div class="notes-text">Ban lãnh đạo thể hiện cam kết tốt. Có thể cải thiện việc truyền đạt tầm quan trọng QMS.</div>
                        </td>
                        <td class="remediation-cell">
                            <span class="remediation-status remediation-status--planned">Đã lên kế hoạch</span>
                            <div class="remediation-deadline">Dự kiến: 30/01/2025</div>
                        </td>
                        <td class="actions-cell">
                            <button class="btn-action btn-action--view" title="Xem chi tiết">👁️</button>
                            <button class="btn-action btn-action--edit" title="Chỉnh sửa">✏️</button>
                            <button class="btn-action btn-action--improve" title="Cải tiến">⚡</button>
                        </td>
                    </tr>

                    <tr class="table-row" data-status="compliant">
                        <td class="criteria-cell">
                            <div class="criteria-code">5.2</div>
                            <div class="criteria-text">Chính sách chất lượng</div>
                        </td>
                        <td class="result-cell">
                            <span class="result-badge result-badge--compliant">✅ Phù hợp</span>
                        </td>
                        <td class="evidence-cell">
                            <div class="evidence-list">
                                <span class="evidence-item">📄 Quality_Policy_2024.pdf</span>
                            </div>
                        </td>
                        <td class="notes-cell">
                            <div class="notes-text">Chính sách chất lượng được xây dựng phù hợp với ISO 9001:2015.</div>
                        </td>
                        <td class="remediation-cell">
                            <span class="remediation-status remediation-status--not-required">Không cần</span>
                        </td>
                        <td class="actions-cell">
                            <button class="btn-action btn-action--view" title="Xem chi tiết">👁️</button>
                            <button class="btn-action btn-action--edit" title="Chỉnh sửa">✏️</button>
                        </td>
                    </tr>

                    <tr class="table-row" data-status="non-compliant">
                        <td class="criteria-cell">
                            <div class="criteria-code">6.1</div>
                            <div class="criteria-text">Hành động ứng phó với rủi ro và cơ hội</div>
                        </td>
                        <td class="result-cell">
                            <span class="result-badge result-badge--non-compliant">❌ Không phù hợp</span>
                        </td>
                        <td class="evidence-cell">
                            <div class="evidence-list">
                                <span class="evidence-item">📸 Risk_Management_Gap.jpg</span>
                            </div>
                        </td>
                        <td class="notes-cell">
                            <div class="notes-text">Chưa có quy trình quản lý rủi ro và cơ hội một cách hệ thống.</div>
                        </td>
                        <td class="remediation-cell">
                            <span class="remediation-status remediation-status--overdue">Quá hạn</span>
                            <div class="remediation-deadline">Hạn: 20/12/2024</div>
                        </td>
                        <td class="actions-cell">
                            <button class="btn-action btn-action--view" title="Xem chi tiết">👁️</button>
                            <button class="btn-action btn-action--edit" title="Chỉnh sửa">✏️</button>
                            <button class="btn-action btn-action--urgent" title="Khẩn cấp">🚨</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-pagination">
            <div class="pagination-info">
                Hiển thị 1-5 của 25 kết quả
            </div>
            <div class="pagination-controls">
                <button class="pagination-btn pagination-btn--disabled">‹ Trước</button>
                <button class="pagination-btn pagination-btn--active">1</button>
                <button class="pagination-btn">2</button>
                <button class="pagination-btn">3</button>
                <button class="pagination-btn">Sau ›</button>
            </div>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="section">
        <div class="section__header">
            <h3 class="section__title">Thống kê tổng hợp</h3>
        </div>

        <div class="statistics-grid">
            <div class="stats-card">
                <div class="stats-card__header">
                    <h4 class="stats-card__title">Phân bố kết quả</h4>
                </div>
                <div class="stats-card__content">
                    <div class="chart-container">
                        <canvas id="resultsChart" width="300" height="200"></canvas>
                    </div>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-card__header">
                    <h4 class="stats-card__title">Tiến độ khắc phục</h4>
                </div>
                <div class="stats-card__content">
                    <div class="remediation-progress">
                        <div class="progress-item">
                            <span class="progress-label">Hoàn thành</span>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 30%"></div>
                            </div>
                            <span class="progress-value">3/10</span>
                        </div>
                        <div class="progress-item">
                            <span class="progress-label">Đang xử lý</span>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 50%"></div>
                            </div>
                            <span class="progress-value">5/10</span>
                        </div>
                        <div class="progress-item">
                            <span class="progress-label">Chưa bắt đầu</span>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 20%"></div>
                            </div>
                            <span class="progress-value">2/10</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Report Modal -->
<div id="create-report-modal" class="program-modal">
    <div class="program-modal-backdrop" data-modal-close="create-report-modal"></div>
    <div class="program-modal-container">
        <div class="program-modal-header">
            <h3 class="program-modal-title">Tạo báo cáo đánh giá mới</h3>
            <button type="button" class="program-modal-close" data-modal-close="create-report-modal">
                <span>&times;</span>
            </button>
        </div>

        <div class="program-modal-body">
            <form method="POST" action="#" class="audit-form-modal" id="create-report-form">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="report_title" class="form-label">Tiêu đề báo cáo *</label>
                        <input type="text" id="report_title" name="report_title" class="form-input"
                               placeholder="Báo cáo đánh giá nội bộ Phòng KHCN - 12/2024" required>
                    </div>

                    <div class="form-group">
                        <label for="report_department" class="form-label">Bộ phận/Phạm vi *</label>
                        <select id="report_department" name="report_department" class="form-select" required>
                            <option value="">Chọn bộ phận</option>
                            <option value="phong-ky-thuat">Phòng Kỹ thuật</option>
                            <option value="phong-khcn">Phòng KHCN</option>
                            <option value="phong-tai-chinh">Phòng Tài chính</option>
                            <option value="phong-nhan-su">Phòng Nhân sự</option>
                            <option value="phong-an-toan">Phòng An toàn</option>
                            <option value="phong-qlcl">Phòng QLCL</option>
                            <option value="ban-giam-doc">Ban Giám đốc</option>
                            <option value="toan-cong-ty">Toàn công ty</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="report_date" class="form-label">Ngày báo cáo *</label>
                        <input type="date" id="report_date" name="report_date" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="report_period" class="form-label">Kỳ báo cáo *</label>
                        <select id="report_period" name="report_period" class="form-select" required>
                            <option value="">Chọn kỳ báo cáo</option>
                            <option value="monthly">Tháng</option>
                            <option value="quarterly">Quý</option>
                            <option value="yearly">Năm</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="lead_auditor_report" class="form-label">Đánh giá viên chính *</label>
                        <select id="lead_auditor_report" name="lead_auditor_report" class="form-select" required>
                            <option value="">Chọn đánh giá viên</option>
                            <option value="nguyen-van-a">Nguyễn Văn A</option>
                            <option value="tran-thi-b">Trần Thị B</option>
                            <option value="le-van-c">Lê Văn C</option>
                            <option value="pham-van-d">Phạm Văn D</option>
                            <option value="hoang-thi-e">Hoàng Thị E</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="standard" class="form-label">Tiêu chuẩn áp dụng</label>
                        <select id="standard" name="standard" class="form-select">
                            <option value="iso-9001">ISO 9001:2015</option>
                            <option value="iso-14001">ISO 14001:2015</option>
                            <option value="iso-45001">ISO 45001:2018</option>
                            <option value="iso-27001">ISO 27001:2013</option>
                        </select>
                    </div>

                    <div class="form-group form-group--full">
                        <label for="report_scope" class="form-label">Phạm vi báo cáo</label>
                        <textarea id="report_scope" name="report_scope" rows="3" class="form-textarea"
                                  placeholder="Mô tả chi tiết phạm vi và mục tiêu của báo cáo đánh giá"></textarea>
                    </div>

                    <div class="form-group form-group--full">
                        <label for="report_notes" class="form-label">Ghi chú</label>
                        <textarea id="report_notes" name="report_notes" rows="2" class="form-textarea"
                                  placeholder="Ghi chú bổ sung cho báo cáo"></textarea>
                    </div>
                </div>
            </form>
        </div>

        <div class="program-modal-footer">
            <button type="button" class="btn btn-outline" data-modal-close="create-report-modal">Hủy bỏ</button>
            <button type="submit" form="create-report-form" class="btn btn-primary">
                <span class="btn-icon">📊</span>
                Tạo báo cáo
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart initialization
    const resultsCtx = document.getElementById('resultsChart').getContext('2d');
    new Chart(resultsCtx, {
        type: 'doughnut',
        data: {
            labels: ['Phù hợp', 'Không phù hợp', 'Cơ hội cải tiến'],
            datasets: [{
                data: [18, 3, 4],
                backgroundColor: ['#059669', '#dc2626', '#3b82f6'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });

    // Modal functionality
    document.querySelectorAll('[data-modal-target]').forEach(trigger => {
        trigger.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('program-modal--active');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach(closeBtn => {
        closeBtn.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-close');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('program-modal--active');
                document.body.style.overflow = '';
                // Reset form
                const form = modal.querySelector('form');
                if (form) form.reset();
            }
        });
    });

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const activeModal = document.querySelector('.program-modal.program-modal--active');
            if (activeModal) {
                activeModal.classList.remove('program-modal--active');
                document.body.style.overflow = '';
            }
        }
    });

    // Export functionality
    document.querySelectorAll('.btn-export').forEach(btn => {
        btn.addEventListener('click', function() {
            const format = this.getAttribute('data-format');
            console.log(`Exporting report as ${format}`);
            // Implement export functionality here
        });
    });

    // Table filtering
    document.querySelectorAll('.form-select').forEach(select => {
        select.addEventListener('change', function() {
            // Implement table filtering logic here
            console.log('Filter changed:', this.value);
        });
    });

    // Action buttons
    document.querySelectorAll('.btn-action').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.className.split(' ').find(cls => cls.includes('--')).split('--')[1];
            console.log(`Action: ${action}`);
            // Implement action functionality here
        });
    });
});
</script>
@endsection