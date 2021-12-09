<a title="Edit" class="btn btn-success" href="{{ route('products.edit', $products->id) }}"><i class="fa fa-edit"></i></a>
@if($productCount < 1)
<a onclick="return confirm('are you suer to delete User')" title="Delete" class="btn btn-danger" href="{{ route('products.delete', $products->id) }}"><i class="fa fa-trash"></i></a>
@endif