<div class="col-md-12">
    <div class="table-responsive">
    <table class="table table-striped custom-table mb-0 datatable">
        <thead>
        <tr>
            <th>#</th>
            <th>Category Name</th>
            <th>Active</th>
            <th>Created Date</th>
            <th class="text-end">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php $catId = 1; ?>
        @foreach ($categoryList as $rsCategoryList)
            <tr>
                <td>{{ $catId }}</td>
                <td>{{ $rsCategoryList->category_name }}</td>
                <td>{{ $rsCategoryList->active == 1 ? 'Yes' : 'No' }}</td>
                <td>{{ date('Y-M-d (l)', strtotime($rsCategoryList->created_at)) }}</td>
                <td class="text-end">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_category" data-bs-catid="{{ $rsCategoryList->id }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        </div>
                    </div>
                </td>
            </tr>
            <?php $catId++; ?>
        @endforeach
        </tbody>
    </table>
    </div>
</div>