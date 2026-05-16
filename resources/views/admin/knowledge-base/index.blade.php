@extends('layouts.main')

@section('title', 'Knowledge Base')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="brand-font mb-1">Knowledge Base</h2>
        <p class="text-muted mb-0">Manage training materials and procurement policies.</p>
    </div>
    <a href="{{ route('admin.knowledge-base.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg me-2"></i> Add Article
    </a>
</div>

<div class="custom-card p-4">
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0" style="background: transparent;">
            <thead>
                <tr>
                    <th class="text-muted fw-normal border-bottom border-secondary">ID</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Title</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Content Snippet</th>
                    <th class="text-muted fw-normal border-bottom border-secondary">Date Added</th>
                    <th class="text-muted fw-normal border-bottom border-secondary text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                <tr>
                    <td class="align-middle">#{{ $loop->iteration }}</td>
                    <td class="align-middle fw-bold">{{ $article->title }}</td>
                    <td class="align-middle text-muted">{{ Str::limit($article->content, 60) }}</td>
                    <td class="align-middle">{{ $article->created_at->format('M d, Y') }}</td>
                    <td class="align-middle text-end">
                        <a href="{{ route('admin.knowledge-base.edit', $article) }}" class="btn btn-sm btn-outline-info rounded-circle me-1" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.knowledge-base.destroy', $article) }}" method="POST" class="d-inline" data-confirm="Delete this article?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="bi bi-journal-x mb-3 d-block fs-1"></i>
                        No articles published yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $articles->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
