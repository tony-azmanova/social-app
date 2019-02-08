<template>
    <div>
        <h1>Upload file</h1>
        <div class=" container upload-file">
            <ImageUploadForm :type="upload" @file="file" :hasPreview="hasPreview"></ImageUploadForm>
        </div>     
    </div>
</template>
<script>
import ImageUploadForm from "../common/ImageUploadForm";

export default {
  components: {
    ImageUploadForm
  },
  data: function() {
    return {
      upload: "file",
      hasPreview: true,
      resetForm: false,
    };
  },
  methods: {
    file(formData, uploadedFile) {
      console.log("uploading file"); //REMOVE_ME
      formData.append("uploadedFile", uploadedFile);
      this.$http
        .post("/files/upload", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(
          response => {
            console.log("image successfully uploadded");
            this.$store.dispatch("files/resetFileInput", true);
            this.$store.dispatch("flashMessages/setSuccess", response.data.message);
          },
          response => {
            this.$store.dispatch("flashMessages/setErrors", response.data.errors);
            console.log("Wooops, Something Went Wrong!");
          }
        );
    }
  }
};
</script>
<style scoped>
.upload-file {
  border-style: solid;
  border-width: 1px;
  border-color: #7098b6;
  margin: 15pt;
  box-shadow: 2px 2px 10px 2px #afc6d8;
}

</style>


