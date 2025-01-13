<div class="modal fade" id="modal-form" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form class="modal-content" id="form-modal" action="javascript:save()">
            <div class="modal-header">
                <h5 class="modal-title">Role</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modal-form-id" name="id">

                <div class="row row-cols-1 row-cols-md-2">
                    <div class="col mb-2">
                        <label for="modal-form-name" class="form-label">Name</label>
                        <input type="text" id="modal-form-name" class="form-control" name="name" required>
                    </div>
                    <div class="col mb-2">
                        <label for="modal-form-status" class="form-label">Status</label>
                        <select id="modal-form-status" class="form-select" name="status" required>
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="col mb-2">
                        <label for="modal-form-admin" class="form-label">Admin</label>
                        <select id="modal-form-admin" class="form-select" name="admin" required>
                            <option value="" hidden selected>Please select...</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>

                <hr class="mb-2">

                <h6>Permissions</h6>
                <div class="row row-cols-1 row-cols-md-3">
                    @foreach ($permissions as $g => $p)

                    @php 
                        if ($g == "others") continue;
                    @endphp

                    <div class="col mb-2">
                        <span class="fw-bold">{{ str_replace("_", " ", ucfirst($g)) }}</span>

                        @foreach ($p as $i)
                        <div class="form-check">
                            <label class="form-check-label" for="modal-form-permission-{{ $i['id'] }}">{{ $i['name'] }}</label>
                            <input class="form-check-input" type="checkbox" value="{{ $i['value'] }}" id="modal-form-permission-{{ $i['id'] }}" name="permissions" />
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>

                @if (isset($permissions['others']))
                <span class="fw-bold">Others</span>
                <div class="row row-cols-3">
                    @foreach ($permissions['others'] as $i)
                    <div class="col mb-2">
                        <div class="form-check">
                            <label class="form-check-label" for="modal-form-permission-{{ $i['id'] }}">{{ $i['name'] }}</label>
                            <input class="form-check-input" type="checkbox" value="{{ $i['value'] }}" id="modal-form-permission-{{ $i['id'] }}" name="permissions" />
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
</div>