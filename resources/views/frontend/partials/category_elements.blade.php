<div class="mb-5">
    @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category->id) as $key => $first_level_id)
        <div class="card shadow-none border-0">
            <a class="text-reset" href="{{ route('products.category', \App\Category::find($first_level_id)->slug) }}"><div class="sidenavContentHeader">{{ \App\Category::find($first_level_id)->getTranslation('name') }}</div></a>
                
                   
              
                @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($first_level_id) as $key => $second_level_id)
					<a class="text-reset" href="{{ route('products.category', \App\Category::find($second_level_id)->slug) }}"><div class="sidenavContent">{{ \App\Category::find($second_level_id)->getTranslation('name') }}</div></a>
                  
                    
                @endforeach
            <hr/>
        </div>
    @endforeach
</div>

