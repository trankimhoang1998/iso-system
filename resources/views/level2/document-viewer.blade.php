<div class="level2-document-viewer">
    <div class="level2-document-info">
        <div class="level2-document-info__header">
            <h3>{{ $document->title }}</h3>
            <div class="level2-document-info__meta">
                <span class="level2-badge level2-badge--{{ $document->document_type }}">
                    {{ $content['document_type'] }}
                </span>
                @if($document->version)
                <span class="level2-text--muted">v{{ $content['version'] }}</span>
                @endif
            </div>
        </div>

        @if($content['description'])
        <div class="level2-document-info__description">
            {{ $content['description'] }}
        </div>
        @endif

        <div class="level2-document-info__details">
            <div class="level2-document-info__row">
                <span class="level2-document-info__label">Kích thước:</span>
                <span>{{ $content['file_size'] }}</span>
            </div>
            <div class="level2-document-info__row">
                <span class="level2-document-info__label">Ngày tải lên:</span>
                <span>{{ $content['created_at'] }}</span>
            </div>
            @if($content['effective_date'])
            <div class="level2-document-info__row">
                <span class="level2-document-info__label">Ngày có hiệu lực:</span>
                <span>{{ $content['effective_date'] }}</span>
            </div>
            @endif
            @if($content['expiry_date'])
            <div class="level2-document-info__row">
                <span class="level2-document-info__label">Ngày hết hiệu lực:</span>
                <span>{{ $content['expiry_date'] }}</span>
            </div>
            @endif
        </div>

        @if($content['tags'])
        <div class="level2-document-info__tags">
            <span class="level2-document-info__label">Tags:</span>
            <div class="level2-tags">
                @foreach($content['tags'] as $tag)
                <span class="level2-tag">{{ trim($tag) }}</span>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="level2-document-actions">
        <a href="{{ route('level2.documents.download', $document) }}" 
           class="level2-btn level2-btn--primary">
            <svg class="level2-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Tải xuống
        </a>
        <button type="button" class="level2-btn level2-btn--secondary" 
                onclick="showProposalModal({{ $document->id }}, '{{ $document->title }}')">
            <svg class="level2-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
            </svg>
            Đề xuất sửa đổi
        </button>
    </div>

    <div class="level2-document-notice">
        <svg class="level2-document-notice__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p>Để xem nội dung chi tiết tài liệu, vui lòng tải xuống file.</p>
    </div>
</div>

<style>
.level2-document-viewer {
    padding: 20px;
    max-height: 500px;
    overflow-y: auto;
}

.level2-document-info__header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
    flex-wrap: wrap;
    gap: 10px;
}

.level2-document-info__header h3 {
    margin: 0;
    font-size: 1.2em;
    font-weight: 600;
    color: #2c3e50;
}

.level2-document-info__meta {
    display: flex;
    gap: 8px;
    align-items: center;
}

.level2-document-info__description {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 20px;
    color: #495057;
    line-height: 1.5;
}

.level2-document-info__details {
    margin-bottom: 20px;
}

.level2-document-info__row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #e9ecef;
}

.level2-document-info__row:last-child {
    border-bottom: none;
}

.level2-document-info__label {
    font-weight: 600;
    color: #495057;
    min-width: 120px;
}

.level2-document-info__tags {
    margin-bottom: 20px;
}

.level2-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    margin-top: 8px;
}

.level2-tag {
    background: #e9ecef;
    color: #495057;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.85em;
}

.level2-document-actions {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.level2-document-notice {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    padding: 15px;
    border-radius: 6px;
    color: #856404;
}

.level2-document-notice__icon {
    width: 20px;
    height: 20px;
    flex-shrink: 0;
}

.level2-document-notice p {
    margin: 0;
    font-size: 0.9em;
}

@media (max-width: 768px) {
    .level2-document-info__header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .level2-document-actions {
        flex-direction: column;
    }
}
</style>