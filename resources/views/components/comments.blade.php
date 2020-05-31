{{-- STR JS --}}
<script src="http://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=">
</script>

<script>
    $(function () {
        var post_id = {{ $post->id }}

        @if(isset(auth()->user()->id))
            var user_id = {{ auth()->user()->id }}
            console.log('user_id:', user_id)
        @endif

        // setup ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        // str get comments
        $.ajax({
            url: "{{ url('/comment/load') }}",
            method: 'get',
            data: {
                post_id
            },
            success: function(response) {
                console.log(response)

                var comments = response.comments

                // str condition
                if(comments && comments.length>0) {
                    // str loop
                    $.each(comments, function(i, comment) {
                        // str html
                        $('#commentCard').append(`
                            <div class="card-body" id="cardBody` + comment.id + `">
                                <small>` + comment.created_at + `, by: ` + comment.user_name + `</small>
                                
                                <p id="old_comment` + comment.id + `"
                                    class="card-text">` + comment.body + `</p>

                                <span class="hidden" id="user_id` + comment.id + `">` + comment.user_id + `</span>

                                <div class="row mar-bot-20">
                                    <div class="col-12">

                                        `
                                        + (
                                            user_id === comment.user_id ?
                                            `
                                            <div class="float-left">
                                                <button
                                                    class="btn btn-sm btn-primary"
                                                    data-toggle="collapse"
                                                    data-target="#editCollapse` + comment.id + `"
                                                    aria-controls="editCollapse` + comment.id + `"
                                                    aria-expanded="false"
                                                >
                                                    <i class="far fa-edit"></i>
                                                </button>

                                                <span id="` + comment.id + `">
                                                    <button class="btn btn-sm btn-danger" id="deleteComment">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </span>
                                            </div>
                                            `
                                            :
                                            ""
                                        ) +
                                        `
                                        
                                        `
                                        + (
                                            true ?
                                            `
                                            <div class="float-right">
                                                <button
                                                    class="btn btn-sm btn-primary"
                                                    id="addReply"
                                                    type="button"
                                                    data-toggle="collapse"
                                                    data-target="#replyCollapse` + comment.id + `"
                                                    aria-controls="replyCollapse` + comment.id + `"
                                                    aria-expanded="false"
                                                    disabled
                                                >
                                                    Show Replies
                                                </button>
                                            </div>
                                            `
                                            :
                                            ""
                                        ) +
                                        `

                                    </div>
                                </div>

                                {{-- str edit collapse --}}
                                <div class="collapse" id="editCollapse` + comment.id + `">
                                    <div class="form-group">
                                        <input type="text" id="new_comment` + comment.id + `"
                                            class="form-control" value="` + comment.body + `">
                                    </div>

                                    <div id="` + comment.id + `">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-success"
                                            id="editComment"
                                            data-toggle="collapse"
                                            data-target="#editCollapse` + comment.id + `"
                                            aria-controls="editCollapse` + comment.id + `"
                                            aria-expanded="false"
                                        >
                                            Save
                                        </button>
                                    </div>
                                </div>
                                {{-- end edit collapse --}}

                                {{-- str reply collapse --}}
                                <div class="collapse ml-5 px-2 py-2" id="replyCollapse` + comment.id + `">
                                    
                                    <div class="card" id="replyCard">
                                        <small>reply card body</small>
                                    </div>

                                </div>
                                {{-- end reply collapse --}}

                                <hr>
                            </div>
                        `)
                        // end html
                    })
                    // end loop
                }
                // end condition
            },
            error: function(error) {
                console.log(error)
            }
        })
        // end get comments

        // str add comment
        $('#addComment').on('click', function (e) {
            e.preventDefault()

            var comment_body = $('#comment_body').val()

            if(comment_body.length <= 0) {
                alert('please type something!')
                return false
            }

            $.ajax({
                url: "{{ url('/comment/store') }}",
                method: 'post',
                data: {
                    post_id,
                    comment_body
                },
                success: function(response) {
                    console.log(response)

                    $('#comment_body').val('')

                    // str html
                    var comment = response.comment

                    $('#commentCard').append(`
                        <div class="card-body" id="cardBody` + comment.id + `">
                            <small>` + comment.created_at + `</small>
                            
                            <p id="old_comment` + comment.id + `"
                                class="card-text">` + comment.body + `</p>

                            <span class="hidden" id="user_id` + comment.id + `">` + comment.user_id + `</span>

                            <div class="row mar-bot-20">
                                <div class="col-12">

                                    `
                                    + (
                                        user_id === comment.user_id ?
                                        `
                                        <div class="float-left">
                                            <button
                                                class="btn btn-sm btn-primary"
                                                data-toggle="collapse"
                                                data-target="#editCollapse` + comment.id + `"
                                                aria-controls="editCollapse` + comment.id + `"
                                                aria-expanded="false"
                                            >
                                                <i class="far fa-edit"></i>
                                            </button>

                                            <span id="` + comment.id + `">
                                                <button class="btn btn-sm btn-danger" id="deleteComment">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </span>
                                        </div>
                                        `
                                        :
                                        ""
                                    ) +
                                    `

                                </div>
                            </div>

                            {{-- str edit collapse --}}
                            <div class="collapse" id="editCollapse` + comment.id + `">
                                <div class="form-group">
                                    <input type="text" id="new_comment` + comment.id + `"
                                        class="form-control" value="` + comment.body + `">
                                </div>
                                
                                <div id="` + comment.id + `">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-success"
                                        id="editComment"
                                        data-toggle="collapse"
                                        data-target="#editCollapse` + comment.id + `"
                                        aria-controls="editCollapse` + comment.id + `"
                                        aria-expanded="false"
                                    >
                                        Save
                                    </button>
                                </div>
                            </div>
                            {{-- end edit collapse --}}

                            <hr>
                        </div>
                    `)
                    // end html
                },
                error: function(error) {
                    console.log(error)
                }
            })
        })
        // end add comment

        // str edit comment
        $(document.body).on('click', '#editComment', function (e) {
            e.preventDefault()

            var comment_id = this.parentNode.id
            console.log('comment_id:',comment_id)
            
            var new_comment = $('#new_comment'+comment_id).val()

            if(new_comment.length <= 0) {
                alert('please type something!')
                return false
            }

            var int_comment_id = parseInt(comment_id, 10)

            $.ajax({
                url: "{{ url('/comment/edit') }}",
                method: 'put',
                data: {
                    comment_id: int_comment_id,
                    comment_body: new_comment,
                },
                success: function(response) {
                    console.log(response)

                    $('#old_comment'+comment_id).text(new_comment)
                },
                error:function(error) {
                    console.log(error)
                }
            })
        })
        // end edit comment

        // str delete comment
        $(document.body).on('click', '#deleteComment', function (e) {
            e.preventDefault()

            var comment_id = this.parentNode.id
            console.log('comment_id:',comment_id)

            var int_comment_id = parseInt(comment_id, 10)

            $.ajax({
                url: "{{ url('/comment/delete') }}",
                method: 'delete',
                data: {
                    comment_id: int_comment_id,
                },
                success: function(response) {
                    console.log(response)

                    $('#cardBody'+comment_id).remove()
                },
                error:function(error) {
                    console.log(error)
                }
            })
        })
        // end delete comment
    })
</script>
{{-- END JS --}}

{{-- STR PHP --}}
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Opinions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        {{-- loop over all comments --}}
        <div class="card" id="commentCard">
            {{-- content placed dynamically by JS --}}
        </div>
        {{-- end loop --}}
        
        <hr>

        {{-- add new comment --}}
        <div class="form-group">
            <input type="text" id="comment_body" class="form-control"
            placeholder="Respect others while you give your opinion">
        </div>
    </div>
  
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-sm btn-primary" id="addComment">Say It</button>
    </div>
</div>
{{-- END PHP --}}
