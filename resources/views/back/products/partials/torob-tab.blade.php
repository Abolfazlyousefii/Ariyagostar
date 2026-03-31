
<div class="tab-pane" id="tabTorob" role="tabpanel" aria-labelledby="torob-tab">
    <div id="torob-card" class="card">
        <div class="card-header d-flex justify-content-between align-items-end">
            <h4 class="card-title">ترب</h4>
        </div>
        <div class="card-content">
            <div class="card-body ">
                <div class="row">
                    <div class="col-md-7 text-justify">
                        <p>در این قسمت لینک های محصول در ترب را وارد کنید تا کمترین قیمت محصول در ترب را نمایش دهد..</p>
                    </div>
                </div>
                <div class="form-body pt-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>لینک های محصول در ترب</label>
                                <textarea class="form-control ltr" name="torob_links" rows="3">{{ $product->torob ? $product->torob->linksText() : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
