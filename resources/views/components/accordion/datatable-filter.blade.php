<div class="card-body">
    <div class="accordion" id="filter-accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter-div">
                    Filters
                </button>
            </h2>
            <div id="filter-div" class="accordion-collapse collapse" data-bs-parent="#filter-accordion">
                <div class="accordion-body">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>