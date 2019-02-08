<template>
    <div class="comment">
        <blockquote class="blockquote">
            <div class="comment-header">
                <UserInfo v-if="comment.user" :user="comment.user"></UserInfo>
            </div>
            <div class="comment-title">
                <h4 class="mb-0">{{ comment.title }}</h4>
            </div>
            <div class="comment-body">
                <cite>{{ comment.body }}</cite>
            </div>
            <footer class="blockquote-footer">
                <div class="comment-created-at">
                   commmented on: {{ comment.created_at }} 
                </div>
            </footer>
        </blockquote>
        <Likes :userHasReacted="comment.userHasReacted" :likesCount="comment.reactions" :element="comment" :elementType="elementType" />
    </div>
</template>

<script>
export default {
  props: {
    comment: {
      type: Object,
      required: true
    }
  },
  data: function() {
    return {
      elementType: "comment"
    };
  },
};
</script>
<style scoped>
    .comment{
        border-style: solid;
        border-color: #b6cfd4;
        border-width: 2px;
        margin: 5%;
        padding-bottom: 2%;
        padding-left: 2%;
        padding-right: 2%;
    }
    .comment-header {
        background: #edf0f2;
        border-bottom-color: #272726;
        border-bottom-style: solid;
        border-bottom-width: 1px;
    }


</style>


