   <h3 class="activity_title">Projects Activity</h3>
            <ul>
               @foreach($project->activity as $activity)
                <li>
                @include("projects.activities.{$activity->description}")
                    <span class="activity-time">{{$activity->created_at->diffForHumans(null,true)}}</span>
                </li>
                @endforeach
                @if($project->tasks_count >= 5)
                <li>
                    <i class="fas fa-grin-alt" style="color:#FBBC05"></i> Hurrah! Your Project have five or more completed tasks
                </li>
                @endif
            </ul>