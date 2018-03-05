@if(get_the_tag_list())
	@php echo get_the_tag_list('<ul class="blog-tags"><li class="btn btn-outline-secondary">','</li><li class="btn btn-outline-secondary">','</li></ul>'); @endphp
@endif