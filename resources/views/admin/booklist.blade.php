@extends('admin.manage_books') <!-- This should extend the main layout -->

@section('admin.book_contents') <!-- This section matches the yield in the main layout -->
<table class="table table-striped">
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Category</th>
        <th>Status</th>
        <th>Borrower</th>
        <th>Manage</th>
    </tr>
    @foreach($books as $book)
        <tr>
            <td>{{$book->title}}</td>
            <td>{{$book->author}}</td>
            <td>{{$book->category}}</td>
            <td>{{$book->status}}</td>
            <td></td>
            <td class="d-flex flex-row">
                <a href="{{route('admin.edit_book', $book->id)}}" class="btn btn-primary">Edit</a>
                <form class="ms-3" action="{{route('admin.delete_book', $book->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">DELETE</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
@endsection