@if ($categoryData)
    <form action="javascript:void(0)">
        <input type="text" value="{{ $categoryData->id }}" class="d-none" id="update_category_id">
        <div class="form-floating mb-3">
            <input type="text" name="category_name" id="update_category_name" class="form-control" placeholder="Category Name" value="{{ $categoryData->category_name }}">
            <label class="label-control" for="category_name">Category Name</label>
        </div>
        <div class="form-floating mb-3">
            <select class="form-select" id="update_category_active" name="category_active">
                <option {{ $categoryData->active == 1 ? 'Selected' : '' }} value="1">Yes</option>
                <option {{ $categoryData->active == 0 ? 'Selected' : '' }} value="0">No</option>
            </select>
            <label class="label-control" for="category_active">Category Active</label>
        </div>
        <div class="w-100 text-center">
            <button type="submit" class="btn btn-success" id="update_category_btn">Update</button>
        </div>
    </form>
@endif