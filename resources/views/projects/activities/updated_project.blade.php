@if(count($activity->changes['after'])==1)
<i class="fas fa-seedling icon-color"></i> {{$activity->user->name}} updated {{key($activity->changes['after'])}} of the project
@else
<i class="fas fa-seedling icon-color"></i> {{$activity->user->name}} updated the project
@endif