<template>
	<div>
		<div class="content">
			<div class="container">
					
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tags <Button @click="addModal = true"><Icon type="md-add" /> Add Category</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
                <th>Icon Image</th>
								<th>Category Name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							 <tr v-for="(category, i) in categoryLists" :key="i" v-if="categoryLists.length">
                <td>{{category.id}}</td>
                <td class="table_image">
                  <img :src="category.iconImage" />
                </td>
                <td class="_table_name">{{category.categoryName}}</td>
                <td>{{category.created_at}}</td>
                <td>
									
 <Button type="info" size="small" @click="showEditModal(category, i)" >Edit</Button>
<Button type="error" size="small" @click="showDeletingModal(category, i)"  :loading="category.isDeleting">Delete</Button>


								</td>
							</tr>
								
						</table>
					</div>
				</div>
				
              	<!--~~~~~~~ Tag Adding Modal ~~~~~~~~~-->
                  <Modal
                  v-model="addModal"
					        title="Add Category"
                    :mask-closable="false"
                    :closable="false"
				>

               <Input v-model="data.categoryName" placeholder="Add category name"  />
                <div slot="space">
                </div>
                <Upload
            
            type="drag"
            :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
            :on-success="handleSuccess"
            :on-error="handleError"
            :format="['jpg','jpeg','png']"
            :max-size="2048"
            :on-format-error="handleFormatError"
            :on-exceeded-size="handleMaxSize"
            action="/app/upload">

           <div style="padding: 20px 0">
              <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
              <p>Click or drag files here to upload</p>
            </div>
          </Upload>

             <div class="demo-upload-list" v-if="data.iconImage">
            <img :src="`${data.iconImage}`" />
            <div class="demo-upload-list-cover">
              <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
            </div>
          </div>
                             
            <div slot="footer">
                <Button type="default" @click="addModal = false">Close</Button>
                <Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding..' : 'Add Category'}}</Button>
            </div>
                  
                  
                </Modal>

                  <!--~~~~~~~ Tag Editing Modal ~~~~~~~~~-->
                  <Modal
                  v-model="editModal"
					         title="Edit Category"
                    :mask-closable="false"
                    :closable="false"
				>

                
                 <Input v-model="editData.categoryName" placeholder="Edit category name"  />
                <div slot="space">
                </div>
                <Upload v-show="isIconImageNew"
            ref="editDataUploads"
            type="drag"
            :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
            :on-success="handleSuccess"
            :on-error="handleError"
            :format="['jpg','jpeg','png']"
            :max-size="2048"
            :on-format-error="handleFormatError"
            :on-exceeded-size="handleMaxSize"
            action="/app/upload">

           <div style="padding: 20px 0">
              <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
              <p>Click or drag files here to upload</p>
            </div>
          </Upload>

 <div class="demo-upload-list" v-if="editData.iconImage">
            <img :src="`${editData.iconImage}`" />
            <div class="demo-upload-list-cover">
              <Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
            </div>
          </div>
                <div slot="footer">
                <Button type="default" @click="closeEditModal">Close</Button>
                <Button type="primary" @click="editCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing..' : 'Edit category'}}</Button>

                </div>
                  </Modal>
                  <!-- delete alert modal -->
				 <Modal v-model="showDeleteModal" width="360">
					<p slot="header" style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation</span>
					</p>
					<div style="text-align:center">
						<p>Are you sure you want to delete Category?.</p>
						
					</div>
					<div slot="footer">
						<Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteTag" >Delete</Button>
					</div>
				</Modal> 
			</div>
		</div>
	</div>
</template>

<script>
import { constants } from 'buffer'
export default {
    
    data(){
        return{
            data : {
                iconImage : '',
                categoryName : ''
            },
            addModal: false,
            editModal: false,
            isAdding : false,
            categoryLists: [],
            editData : {
                 iconImage : '',
                categoryName : ''
            },
            index : -1,
            showDeleteModal : false,
            isDeleting : false,
            deleteItem: {},
            deletingIndex: -1,
            token : "",
            isIconImageNew : false,
            isEditingItem : false,
            websiteSettings: []
        }
    },
    
    methods : {
        async addCategory() {
      if (this.data.categoryName.trim() == "")
        return this.e("Category name is required");
      if (this.data.iconImage.trim() == "")
        return this.e("Icon image is required");
      this.data.iconImage = `${this.data.iconImage}`;
      const res = await this.callApi("post", "app/create_category", this.data);
      if (res.status === 201) {
        console.log(res.data);
        this.categoryLists.unshift(res.data);
        this.s("Category has been added successfully!");
        this.addModal = false;
        this.data.categoryName = "";
        this.data.iconImage = "";
      } else {
        if (res.status == 422) {
          if (res.data.errors.categoryName) {
            this.e(res.data.errors.categoryName[0]);
          }
          if (res.data.errors.iconImage) {
            this.e(res.data.errors.iconImage[0]);
          }
        } else {
          this.swr();
        }
      }
    },
     async editCategory() {
      if (this.editData.categoryName.trim() == "")
        return this.e("Category name is required");
      if (this.editData.iconImage.trim() == "")
        return this.e("Icon image is required");
      const res = await this.callApi(
        "post",
        "app/edit_category",
        this.editData
      );
      if (res.status === 200) {
        this.categoryLists[
          this.index
        ].categoryName = this.editData.categoryName;
        this.s("Category has been edited successfully!");
        this.editModal = false;
      } else {
        if (res.status == 422) {
          if (res.data.errors.categoryName) {
            this.e(res.data.errors.categoryName[0]);
          }
          if (res.data.errors.iconImage) {
            this.e(res.data.errors.iconImage[0]);
          }
        } else {
          this.swr();
        }
      }
    },
        showEditModal(category, index){
            // let obj ={
            //     id : tag.id,
            //     tagName : tag.tagName
            // }
        this.editData = category
        this.editModal = true
        this.index = index
        this.isEditingItem = true
    },
    async deleteTag(tag,i){
    //     if(!confirm['Are you sure you want to delete this tag'])
    //    return this.$set(tag, 'isDeleting',true)
    this.isDeleting = true
         const res = await this.callApi('post', 'app/delete_tag', this.deleteItem)
         if(res.status===200){
             this.tags.splice(this.deletingIndex,1)
             this.s('Tag has been deleted')
         }
        else{
            this.swr()
        }
    },
    showDeletingModal(tag,i){
        this.deleteItem = tag
        this.deletingIndex = i
        this.showDeleteModal = true
     
    },
    
    handleSuccess (res,file) {
         res = `/uploads/${res}`;
     
      if(this.isEditingItem){
        return this.editData.iconImage = res
      }
        this.data.iconImage = res
    },
    handleError(res, file) {
      this.$Notice.warning({
        title: "The file format is incorrect",
        desc: `${
          file.errors.file.length
            ? file.errors.file[0]
            : "Something went wrong!"
        }`
      });
    },
    handleFormatError (file) {
        this.$Notice.warning({
            title: "The file format is incorrect",
            decs:
            "File format of " +
            file.name + 
            " is incorrect, please select jpg or png"
        });
    },
    handleMaxSize(file){
        this.$Notice.warning({
            title: "Exceeding file size limit",
            desc: "File " + file.name + "is too large, no more than 2M"
        });
    },
    
    async deleteImage(isAdd=true){
      let image;
      if (!isAdd) {
        // for editing....
        this.isIconImageNew = true;
        image = this.editData.iconImage;
        this.editData.iconImage = "";
        this.$refs.editDataUploads.clearFiles();
      } else {
        image = this.data.iconImage;
        this.data.iconImage = "";
        this.$refs.uploads.clearFiles();
      }
      if(!isAdd){ // for editing
        this.isIconImageNew = true
        let image = this.data.iconImage;
         this.data.iconImage = ''
         this.$refs.editDataUploads.clearFiles()
      }
      else{
         let image = this.data.iconImage;
         this.data.iconImage = ''
         this.$refs.uploads.clearFiles()
      }
      
    const res = await this.callApi("post", "app/delete_image", {
        imageName: image
      });
      if (res.status != 200) {
        this.data.iconImage = image;
        this.swr();
      }
      },
      closeEditModal(){
        this.isEditingItem = false
        this.editModal = false
      }
    },
    async created(){
        this.token = window.Laravel.csrfToken
        const res = await this.callApi('get', '/app/get_category');
        console.log(res)
        if(res.status==200){
           this.categoryLists = res.data
        }
        else{
            this.swr
        }
        
    }
}
</script>