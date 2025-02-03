<!-- resources/views/posts/create.blade.php -->

@if(session('success_message'))
    <div style="color: green;">
        {{ session('success_message') }}
    </div>
@endif

@if(session('error_message'))
    <div style="color: red;">
        {{ session('error_message') }}
    </div>
@endif

<form action="{{ route('posts.store') }}" method="POST">
    @csrf
    <div>
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}" required>
        @error('title')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="description">Description</label>
        <textarea id="description" name="description" required>{{ old('description') }}</textarea>
        @error('description')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit">Create Post</button>
</form>

