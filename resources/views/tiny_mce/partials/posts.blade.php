@foreach($posts as $post)
<div class="col" data-id="{{$post->id}}">
   <a href="{{ route('post_show', $post->id) }}" class="text-reset text-decoration-none">
      <div class="card h-100 border-0 shadow rounded-3 ">
         <div class="imgContainer">
            <img src="/storage/photos/posts/{{ $post->image }}" class="card-img-top rounded-top-3">
         </div>
         <div class="card-body align-middle">
            <table class="w-100 h-100">
               <tbody>
                  <tr>
                     <td class="ellipsis js-getDescription me-1 ">
                        <h5 class="card-title mb-0">{{ $post->title }}</h5>
                     </td>
                     <td style="">
                        <div class="dropdown">
                           <a class="btn bg-body-secondary float-end px-1 py-0" href="#" role="button"
                              data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bi bi-three-dots-vertical fs-4  text-dark-emphasis"></i>
                           </a>
                           <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink " style="">
                              <li>
                                 <a class="dropdown-item text-center js_edit_post_btn" value="{{ $post->id }}"
                                    data-bs-toggle="modal" data-bs-target="#edit_post_modal"
                                    data-post-id="{{ $post->id }}" href="#"><i
                                       class="bi bi-pencil-square colorBlack font_icon_size"> </i>{{
                                    __("js_translations.edit")}}</a>
                              </li>
                              <li>
                                 <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                    class="post_delete_form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-center js-delete-btn"><i
                                          class="bi bi-trash-fill text-danger font_icon_size"></i> {{
                                       __("js_translations.delete")}}</button>
                                 </form>
                              </li>
                           </ul>
                        </div>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </a>
</div>
@endforeach