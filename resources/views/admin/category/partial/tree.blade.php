@unless ($categories->isEmpty())
    <ul class="category-tree">
        @foreach ($categories as $category)
            <li>
                <a href="{{ route('admin.categories.show', [ $category->getKey() ]) }}" class="title">
                    {{ $category->name }}
                </a>
                <span class="actions">
                    <a href="{{ route('admin.categories.edit', [ $category->getKey() ]) }}" title="Edit this category">
                        <i class="fas fa-pen-square"></i>
                    </a>

                    <a href="{{ route('admin.categories.create', [ 'parent_id' => $category->getKey() ]) }}" title="Create child">
                        <i class="fas fa-plus-square"></i>
                    </a>
                </span>
                @include('admin.category.partial.tree', [ 'categories' => $category->children ])
            </li>
        @endforeach
    </ul>
@endunless