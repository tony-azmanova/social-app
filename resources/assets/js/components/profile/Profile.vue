<template>
  <div>
    <div class="container col-12 ml-1">
      <div class="page-header">
        <h1>My Profile</h1>
      </div>
      <UserInformation v-if="user.id" :user="user"/>
    </div>
    <div class="container col-8 ml-1">
      <transition enter-active-class="animated fadeInDown slower" leave-active-class="animated fadeOutUp slower">
        <div :class="classFadeOut" v-if="showImageUpload">
          <div class="avatar-upload-form">
            <ImageUploadForm :type="upload" @avatar="avatar" :hasPreview="hasPreview"/>
          </div>
        </div>
      </transition>
    </div>
    <LatestCard v-if="user.id" :user="user"/>
  </div>
</template>

<script>
import store from '../../store';
import { mapState } from 'vuex';
import LatestCard from './LatestCard';
import UserInformation from './UserInformation';
import ImageUploadForm from '../common/ImageUploadForm';

export default {
  components: {
    LatestCard,
    UserInformation,
    ImageUploadForm
  },
  props: {
    userId: {}
  },
  data: function() {
    return {
      classFadeOut: "animated fadeInDown slower",
      showImageUpload: false,
      upload: "avatar",
      hasPreview: false,
    };
  },
  computed: {
    ...mapState({
      user: state => state.users.userData
    })
  },
  methods: {
    avatar(formData, uploadedFile) {
      formData.append('uploadedFile', uploadedFile);
      this.$http
        .post('/avatar/upload', formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }
          ).then(
            response => {
              this.$store.dispatch("users/setUserAvatar", response.data.data);
              this.$store.dispatch("files/resetFileInput", true);
              this.$store.dispatch("flashMessages/setSuccess", response.data.message);
              this.classFadeOut = "animated fadeOutUp slower";
            },
            response => {
              this.$store.dispatch("flashMessages/setErrors", response.data.errors);
              console.log("Wooops, Something Went Wrong!", response.data.errors);
            }
          ); 
    },
  },
  created: function created() {
    this.$on('showImageUploadForm', function(event) {
      this.showImageUpload = !this.showImageUpload;
      this.classFadeOut = this.showImageUpload ? "animated fadeInDown slower" : "animated fadeOutUp slower";
    });
  }
};
</script>
