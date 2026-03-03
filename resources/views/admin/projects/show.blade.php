@extends("layouts.admin")

@section("title", $project->name)

@section("content")
    <main>
        <section class="admin-container">
            <div class="admin-header">
                <div>
                    <h2 class="text-2xl font-bold">{{ $project->name }}</h2>
                    <p>Project Details</p>
                </div>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-outline">← Back to Projects</a>
            </div>

            <div class="admin-grid">
                <!-- Project Info Card -->
                <div class="activity-card">
                    <h3 class="text-lg font-bold mb-4">General Information</h3>

                    <div class="activity-item">
                        <strong style="color: var(--text); min-width: 120px;">Creator:</strong>
                        <span style="color: var(--subtext);">{{ $project->user->name ?? 'Unknown' }}</span>
                    </div>
                    <div class="activity-item">
                        <strong style="color: var(--text); min-width: 120px;">Course:</strong>
                        <span style="color: var(--subtext);">{{ $project->course->name ?? 'N/A' }}</span>
                    </div>
                    <div class="activity-item">
                        <strong style="color: var(--text); min-width: 120px;">Subject:</strong>
                        <span style="color: var(--subtext);">{{ $project->subject->name ?? 'N/A' }}</span>
                    </div>
                    <div class="activity-item">
                        <strong style="color: var(--text); min-width: 120px;">Status:</strong>
                        <span class="badge-pill {{ $project->status ? 'badge-pill-active' : 'badge-pill-inactive' }}">
                            {{ $project->status ? 'Active' : 'Draft' }}
                        </span>
                    </div>
                    <div class="activity-item">
                        <strong style="color: var(--text); min-width: 120px;">Created:</strong>
                        <span style="color: var(--subtext);">{{ $project->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    @if($project->github_url)
                    <div class="activity-item">
                        <strong style="color: var(--text); min-width: 120px;">GitHub:</strong>
                        <a href="{{ $project->github_url }}" target="_blank" style="color: var(--subtext);">{{ $project->github_url }}</a>
                    </div>
                    @endif
                    @if($project->live_url)
                    <div class="activity-item">
                        <strong style="color: var(--text); min-width: 120px;">Live URL:</strong>
                        <a href="{{ $project->live_url }}" target="_blank" style="color: var(--subtext);">{{ $project->live_url }}</a>
                    </div>
                    @endif
                </div>

                <!-- Tags & Description -->
                <div class="activity-card">
                    <h3 class="text-lg font-bold mb-4">Description</h3>
                    <p style="color: var(--subtext); white-space: pre-line;">{{ $project->description ?? 'No description provided.' }}</p>

                    @if($project->tags->count() > 0)
                        <h3 class="text-lg font-bold mb-4 mt-6">Tags</h3>
                        <div>
                            @foreach($project->tags as $tag)
                                <span class="tag">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Files -->
            @if($project->files->count() > 0)
                <div class="admin-section">
                    <h3 class="text-lg font-bold mb-4">Project Files</h3>
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($project->files as $file)
                                    <tr>
                                        <td>{{ $file->name }}</td>
                                        <td>{{ $file->file_type ?? 'N/A' }}</td>
                                        <td>
                                            <span class="status-badge {{ $file->status ? 'active' : 'inactive' }}">
                                                {{ $file->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Comments -->
            @if($project->comments->count() > 0)
                <div class="admin-section">
                    <h3 class="text-lg font-bold mb-4">Comments ({{ $project->comments->count() }})</h3>
                    @foreach($project->comments->where('parent_id', null) as $comment)
                        <div class="activity-card mb-4" style="margin-bottom: 1rem;">
                            <div class="activity-item">
                                <div class="icon-circle">💬</div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-sm">{{ $comment->user->name ?? 'Unknown' }}</h4>
                                    <p class="text-xs" style="color: var(--subtext);">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <p style="color: var(--subtext); padding: 0.5rem 0;">{{ $comment->text }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
@endsection
