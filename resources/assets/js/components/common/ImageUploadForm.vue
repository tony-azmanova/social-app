<template>
  <div>
    <Errors></Errors>
    <Success></Success>
    <div class="imageUploadForm">
      <form enctype="multipart/form-data" v-on:submit.prevent="$emit(type, formData, uploadedFile)" :type="type">
        Upload file:
        <input type="file" id="uploadedFile" ref="fileUploaded" accept="image/*" v-on:change="onImageChange($event)">
        <button type="submit" class="btn btn-primary">Upload</button>
      </form>
    </div>
    <div class="preview">
        <img v-if="(url && hasPreview)" :src="url" />
    </div>
  </div>
</template>
<script>
import store from "../../store";
import { mapState } from "vuex";

export default {
  props: {
    type: {
      type: String,
      required: true
    },
    hasPreview: {
      type: Boolean
    }
  },
  data() {
    return {
      formData: new FormData(),
      uploadedFile: {},
      url: null,
      errorForFileNotOfType:
        "The uploaded file must be a file of type: jpeg, png, jpg."
    };
  },
  computed: {
    ...mapState({
      resetForm: state => state.files.resetFileInput
    })
  },
  beforeUpdate() {
    if (this.resetForm) {
      this.reset();
      this.url = "";
    }
  },
  methods: {
    onImageChange(e) {
      this.uploadedFile = e.target.files[0];
      if (!this.uploadedFile.type.match("image.*")) {
        this.$store.dispatch("flashMessages/setErrors", {
          uploadedFile: [this.errorForFileNotOfType]
        });
        //do this with dispach
        this.reset();
        return;
      }
      this.$store.dispatch("files/resetFileInput", false);
      this.url = URL.createObjectURL(this.uploadedFile);
      this.$store.dispatch("flashMessages/removeErrors", {});
    },
    reset() {
      const input = this.$refs.fileUploaded;
      input.type = "text";
      input.type = "file";
    }
  }
};
</script>
<style scoped>
.preview {
  display: flex;
  justify-content: center;
  align-items: center;
  padding-top: 15%;
}
.imageUploadForm {
  display: flex;
  justify-content: center;
  align-items: center;
  padding-top: 8%;
}
</style>


