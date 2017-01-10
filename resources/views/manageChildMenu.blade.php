<ul class="submenu">
	@foreach($childs as $child)
			@if(count($child->childs))
		    	<li class="dropdown-submenu">
                    <a class="dropdown-toggle" href="{{ url('/category/' . $child->id ) }}">{{ $child->name_cat }} [{{ count($child->lots) }}]</a>
                    @include('manageChildMenu',['childs' => $child->childs])
                </li>
		    @else
		    	<li><a href="{{ url('/category/' . $child->id ) }}">{{ $child->name_cat }} [{{ count($child->lots) }}]</a></li>
	        @endif
	@endforeach
</ul>