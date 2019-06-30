<div class="images_wrapper">
    <label>Select image</label>
    <div class="images">
    @foreach($images as $key => $image)
    
        <div class="prev_image">          
            <input type="checkbox" id="cb{{$key}}" />
            <label for="cb{{$key}}"><img selId="cb{{$key}}" src="{{ '/storage/'.$image}}"  /></label>
            
        </div>
    @endforeach
    </div>    
</div>