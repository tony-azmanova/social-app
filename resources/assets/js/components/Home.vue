<template>
    <div class="homePage">
        <div class="content">
            <div class="title m-b-md">
                Social.app
            </div>
        </div>
    </div>
</template>
<script>
import store from "../store";
import { mapState } from "vuex";

export default {
  computed: {
    ...mapState({
      authUserId: state => state.users.authUserId,
    })
  }
};
</script>

<style scoped>
    .homePage {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Raleway', sans-serif;
        font-weight: 100;
        height: 100%;
        margin: 0;
        border-width: 1px;
        width: 100%;
        border-color: #7098b6;
        box-shadow: 2px 2px 10px 2px #afc6d8
    }

    .top-right {
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
        border-style: solid;
    }

    .title {
        font-size: 84px;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        margin-bottom: 30px;
    }
</style>

