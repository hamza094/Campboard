   <h3 class="activity_title">Projects Activity</h3>
            <ul>
               @foreach($project->activity as $activity)
                <li>
                @include("projects.activities.{$activity->description}")
                    <span class="activity-time">{{$activity->created_at->diffForHumans(null,true)}}</span>
                </li>
                @endforeach
            </ul>