@extends('layouts.admin')

@section('title', 'Đánh Giá Nội Bộ - Thực Hiện')

@section('content')
<div class="container audit-implementation">
    <div class="page-header">
        <h1 class="page-header__title">THỰC HIỆN ĐÁNH GIÁ NỘI BỘ</h1>
        <div class="page-header__breadcrumb">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span class="breadcrumb-separator">></span>
            <a href="{{ route('admin.audit.summary') }}">Đánh giá nội bộ</a>
            <span class="breadcrumb-separator">></span>
            <span>Thực hiện</span>
        </div>
    </div>

    <!-- Current Audit Session -->
    <div class="section">
        <div class="section__header">
            <h2 class="section__title">Đánh giá Phòng KHCN - ISO 9001:2015</h2>
            <div class="section__meta">
                <span class="meta-item">Ngày: 25/12/2024</span>
                <span class="meta-item">Đánh giá viên: Nguyễn Văn A</span>
                <span class="audit-status audit-status--active">Đang thực hiện</span>
            </div>
        </div>

        <!-- Progress Overview -->
        <div class="audit-progress-overview">
            <div class="progress-stats">
                <div class="progress-stat">
                    <span class="progress-stat__label">Hoàn thành</span>
                    <span class="progress-stat__value">15/25</span>
                </div>
                <div class="progress-stat">
                    <span class="progress-stat__label">Phù hợp</span>
                    <span class="progress-stat__value compliance--good">12</span>
                </div>
                <div class="progress-stat">
                    <span class="progress-stat__label">Không phù hợp</span>
                    <span class="progress-stat__value compliance--bad">2</span>
                </div>
                <div class="progress-stat">
                    <span class="progress-stat__label">Cơ hội cải tiến</span>
                    <span class="progress-stat__value compliance--opportunity">1</span>
                </div>
            </div>
            <div class="progress-bar-container">
                <div class="progress-bar">
                    <div class="progress-bar__fill" style="width: 60%"></div>
                </div>
                <span class="progress-percentage">60%</span>
            </div>
        </div>
    </div>

    <!-- ISO 9001:2015 Checklist -->
    <div class="section">
        <div class="section__header">
            <h3 class="section__title">Danh sách kiểm tra ISO 9001:2015</h3>
            <div class="section__filters">
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

        <div class="audit-checklist">
            <!-- Section 4: Context of Organization -->
            <div class="checklist-section">
                <h4 class="checklist-section__title">4. Bối cảnh của tổ chức</h4>

                <div class="checklist-item">
                    <div class="checklist-item__header">
                        <span class="item-code">4.1</span>
                        <span class="item-title">Hiểu rõ tổ chức và bối cảnh của nó</span>
                    </div>
                    <div class="checklist-item__content">
                        <div class="assessment-buttons">
                            <button type="button" class="assessment-btn assessment-btn--compliant" data-status="compliant">
                                ✅ Phù hợp
                            </button>
                            <button type="button" class="assessment-btn assessment-btn--non-compliant" data-status="non-compliant">
                                ❌ Không phù hợp
                            </button>
                            <button type="button" class="assessment-btn assessment-btn--opportunity" data-status="opportunity">
                                ⚠️ Cơ hội cải tiến
                            </button>
                        </div>
                        <div class="assessment-notes">
                            <textarea class="form-textarea" placeholder="Ghi chú đánh giá, phát hiện hoặc khuyến nghị..."></textarea>
                        </div>
                        <div class="evidence-upload">
                            <label class="upload-label">
                                <input type="file" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="upload-input">
                                <span class="upload-text">📎 Tải lên minh chứng</span>
                            </label>
                            <div class="uploaded-files"></div>
                        </div>
                    </div>
                </div>

                <div class="checklist-item">
                    <div class="checklist-item__header">
                        <span class="item-code">4.2</span>
                        <span class="item-title">Hiểu rõ nhu cầu và kỳ vọng của các bên liên quan</span>
                    </div>
                    <div class="checklist-item__content">
                        <div class="assessment-buttons">
                            <button type="button" class="assessment-btn assessment-btn--compliant active" data-status="compliant">
                                ✅ Phù hợp
                            </button>
                            <button type="button" class="assessment-btn assessment-btn--non-compliant" data-status="non-compliant">
                                ❌ Không phù hợp
                            </button>
                            <button type="button" class="assessment-btn assessment-btn--opportunity" data-status="opportunity">
                                ⚠️ Cơ hội cải tiến
                            </button>
                        </div>
                        <div class="assessment-notes">
                            <textarea class="form-textarea" placeholder="Ghi chú đánh giá, phát hiện hoặc khuyến nghị...">Tổ chức đã xác định được các bên liên quan chính và nhu cầu của họ. Tài liệu được cập nhật định kỳ.</textarea>
                        </div>
                        <div class="evidence-upload">
                            <label class="upload-label">
                                <input type="file" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="upload-input">
                                <span class="upload-text">📎 Tải lên minh chứng</span>
                            </label>
                            <div class="uploaded-files">
                                <div class="uploaded-file">
                                    <span class="file-name">Stakeholder_Analysis_2024.pdf</span>
                                    <button type="button" class="file-remove">×</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="checklist-item">
                    <div class="checklist-item__header">
                        <span class="item-code">4.3</span>
                        <span class="item-title">Xác định phạm vi của hệ thống quản lý chất lượng</span>
                    </div>
                    <div class="checklist-item__content">
                        <div class="assessment-buttons">
                            <button type="button" class="assessment-btn assessment-btn--compliant" data-status="compliant">
                                ✅ Phù hợp
                            </button>
                            <button type="button" class="assessment-btn assessment-btn--non-compliant active" data-status="non-compliant">
                                ❌ Không phù hợp
                            </button>
                            <button type="button" class="assessment-btn assessment-btn--opportunity" data-status="opportunity">
                                ⚠️ Cơ hội cải tiến
                            </button>
                        </div>
                        <div class="assessment-notes">
                            <textarea class="form-textarea" placeholder="Ghi chú đánh giá, phát hiện hoặc khuyến nghị...">Phạm vi QMS chưa được mô tả đầy đủ. Thiếu thông tin về các quy trình ngoại vi và ranh giới ứng dụng.</textarea>
                        </div>
                        <div class="evidence-upload">
                            <label class="upload-label">
                                <input type="file" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="upload-input">
                                <span class="upload-text">📎 Tải lên minh chứng</span>
                            </label>
                            <div class="uploaded-files">
                                <div class="uploaded-file">
                                    <span class="file-name">QMS_Scope_Issues.jpg</span>
                                    <button type="button" class="file-remove">×</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 5: Leadership -->
            <div class="checklist-section">
                <h4 class="checklist-section__title">5. Lãnh đạo</h4>

                <div class="checklist-item">
                    <div class="checklist-item__header">
                        <span class="item-code">5.1</span>
                        <span class="item-title">Lãnh đạo và cam kết</span>
                    </div>
                    <div class="checklist-item__content">
                        <div class="assessment-buttons">
                            <button type="button" class="assessment-btn assessment-btn--compliant" data-status="compliant">
                                ✅ Phù hợp
                            </button>
                            <button type="button" class="assessment-btn assessment-btn--non-compliant" data-status="non-compliant">
                                ❌ Không phù hợp
                            </button>
                            <button type="button" class="assessment-btn assessment-btn--opportunity active" data-status="opportunity">
                                ⚠️ Cơ hội cải tiến
                            </button>
                        </div>
                        <div class="assessment-notes">
                            <textarea class="form-textarea" placeholder="Ghi chú đánh giá, phát hiện hoặc khuyến nghị...">Ban lãnh đạo thể hiện cam kết tốt với QMS. Tuy nhiên, có thể cải thiện thêm việc truyền đạt tầm quan trọng của QMS đến toàn thể nhân viên.</textarea>
                        </div>
                        <div class="evidence-upload">
                            <label class="upload-label">
                                <input type="file" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="upload-input">
                                <span class="upload-text">📎 Tải lên minh chứng</span>
                            </label>
                            <div class="uploaded-files"></div>
                        </div>
                    </div>
                </div>

                <div class="checklist-item">
                    <div class="checklist-item__header">
                        <span class="item-code">5.2</span>
                        <span class="item-title">Chính sách chất lượng</span>
                    </div>
                    <div class="checklist-item__content">
                        <div class="assessment-buttons">
                            <button type="button" class="assessment-btn assessment-btn--compliant active" data-status="compliant">
                                ✅ Phù hợp
                            </button>
                            <button type="button" class="assessment-btn assessment-btn--non-compliant" data-status="non-compliant">
                                ❌ Không phù hợp
                            </button>
                            <button type="button" class="assessment-btn assessment-btn--opportunity" data-status="opportunity">
                                ⚠️ Cơ hội cải tiến
                            </button>
                        </div>
                        <div class="assessment-notes">
                            <textarea class="form-textarea" placeholder="Ghi chú đánh giá, phát hiện hoặc khuyến nghị...">Chính sách chất lượng được xây dựng phù hợp với ISO 9001:2015 và được truyền đạt tốt trong tổ chức.</textarea>
                        </div>
                        <div class="evidence-upload">
                            <label class="upload-label">
                                <input type="file" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="upload-input">
                                <span class="upload-text">📎 Tải lên minh chứng</span>
                            </label>
                            <div class="uploaded-files">
                                <div class="uploaded-file">
                                    <span class="file-name">Quality_Policy_2024.pdf</span>
                                    <button type="button" class="file-remove">×</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="audit-actions">
            <button type="button" class="btn btn-outline">Lưu nháp</button>
            <button type="button" class="btn btn-secondary">Tạm dừng</button>
            <button type="button" class="btn btn-primary">Hoàn thành đánh giá</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Assessment button functionality
    document.querySelectorAll('.assessment-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from siblings
            const siblings = this.parentElement.querySelectorAll('.assessment-btn');
            siblings.forEach(sibling => sibling.classList.remove('active'));

            // Add active class to clicked button
            this.classList.add('active');

            // Update item status
            const item = this.closest('.checklist-item');
            const status = this.getAttribute('data-status');
            item.setAttribute('data-status', status);
        });
    });

    // File upload functionality
    document.querySelectorAll('.upload-input').forEach(input => {
        input.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            const container = this.closest('.evidence-upload').querySelector('.uploaded-files');

            files.forEach(file => {
                const fileDiv = document.createElement('div');
                fileDiv.className = 'uploaded-file';
                fileDiv.innerHTML = `
                    <span class="file-name">${file.name}</span>
                    <button type="button" class="file-remove">×</button>
                `;

                // Add remove functionality
                fileDiv.querySelector('.file-remove').addEventListener('click', function() {
                    fileDiv.remove();
                });

                container.appendChild(fileDiv);
            });

            // Clear input
            this.value = '';
        });
    });

    // Remove file functionality for existing files
    document.querySelectorAll('.file-remove').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.uploaded-file').remove();
        });
    });
});
</script>
@endsection