<ul>
	@foreach($childs as $child)
		<li>
			@if(count($child->childs))
		    	<i class="indicator icon-plus-sign"></i>
		    @endif
		    {{ $child->name_cat }}
			@if(count($child->childs))
	            @include('manageChild',['childs' => $child->childs])
	        @endif
		</li>
	@endforeach
</ul>