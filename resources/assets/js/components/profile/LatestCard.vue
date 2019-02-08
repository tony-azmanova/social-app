<template>
  <div class="card-deck mt-5">
        <div v-if="user.latestDates.latestPostDate" class="card">
            <div class="card-body">
                <h5 class="card-title">Total posts</h5>
                <p class="card-text">You have posted a total of</p>
                <p class="card-text"><b>{{ user.posts_count }} post</b></p>
            </div>
            <div class="card-footer">
                <small class="text-muted">Last post added {{ user.latestDates.latestPostDate }}</small>
            </div>
        </div>
        <div v-if="user.latestDates.latestImageDate" class="card">
            <div class="card-body">
                <h5 class="card-title">Total images uploaded</h5>
                <p class="card-text">You have a total of</p>
                <p class="card-text"><b>{{ user.files_count }} images uploaded</b></p>
            </div>
            <div class="card-footer">
                <small class="text-muted">Last image uploaded {{ user.latestDates.latestImageDate }}</small>
            </div>
        </div>
        <div v-if="user.latestDates.latestCommentDate" class="card">
            <div class="card-body">
                <h5 class="card-title">Total comments added</h5>
                <p class="card-text">You have written a total of</p>
                <p class="card-text"><b>{{ user.comments_count }} comments</b></p>
            </div>
            <div class="card-footer">
                <small class="text-muted">Last comment added {{ user.latestDates.latestCommentDate }}</small>
            </div>
        </div>
  </div>
</template>
<script>
export default {
  props: {
    user: {
      type: Object,
      required: true
    }
  }
};
</script>
