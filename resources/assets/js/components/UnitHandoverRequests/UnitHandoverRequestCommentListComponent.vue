<template>    
    <div class="comment-list-container">
        <div class="comment-imput-container d-flex" v-if="allowComment">
            <div class="comment-section">                               
                <div class="comment-detail-container bg-light p-2">                  
                    <div class="form-group">
                        <textarea class="form-control" id="content" name="content" rows="2" placeholder="Write your comment..." 
                            v-model="content" @keydown="onKeyDown" @change="handleInputChanged"></textarea>
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Max length 250 characters: {{ content.length }} / 250
                        </small>
                    </div>
                    <div class="custom-file mb-2">
                        <input type="file" multiple="multiple" class="custom-file-input" name="images" ref="file" v-on:change="handleFileUpload()">
                        <label class="custom-file-label" for="customFile">Select Images to upload</label>
                    </div>
                    <p class="text-danger" v-if="isError">{{ errorMsg }}</p>
                    <button type="submit" @click="onCommentFormSumbitted" class="btn btn-sm btn-primary">Submit</button>
                </div>
            </div>
        </div>
        <div class="comment-list">
            <div class="comment-container d-flex" v-for="comment in items" :key="comment.id">
                <div class="commentor-avatar-container">
                    <img v-bind:src="comment.commentor.avatar_url" width="48px">
                </div>
                <div class="comment-section px-2">
                    <div class="comment-meta-container d-flex">
                        <div class="commentor-name flex-fill">
                            <strong>{{ comment.commentor.name }}</strong>
                        </div>
                        <div class="commentor-timestamp flex-fill">
                            <span class="d-block text-right text-muted"><small>{{ comment.created_at | diffForHuman }}</small></span>
                        </div>
                    </div>
                    <div class="comment-detail-container bg-light p-2">
                        <pre class="mb-0">{{ comment.content }}</pre>
                        <div class="comment-image-gallery-container" v-if="comment.media != null && comment.media.length > 0">
                            <Photoswipe v-bind:lazy="false">
                                <img  class="img-thumbnail" 
                                    v-for="media in comment.media"
                                    :src="media.thumbnail_url" v-pswp="media.url"
                                /> 
                            </Photoswipe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <load-more-pagination 
            :paginationData="paginateMeta"
            v-on:on-load-more-button-clicked="paginate"
        ></load-more-pagination>  
    </div>   
</template>

<style lang="scss" scoped>
    .comment-container {
        padding: 1rem 0;
    }
    .comment-imput-container {      
        border-bottom: 1px solid #f5f5f5;
    }
    .comment-section {
        width: 100%;
    }
    .comment-detail-container p:last-child {
        margin-bottom: 0px !important;
    }

    .comment-detail-container pre {
        font-family: "Nunito", "khmerOsContent", sans-serif, cursive;
    }
</style>
<script>

import LoadMorePagination from '../utils/LoadMoreComponent';

export default {
    components : {       
        'load-more-pagination': LoadMorePagination,
    },
    props: {     
        id: null,
        allowComment: {
            default: true,
            type: Boolean
        }
    },
    data : () => {
        return {
            items:[],
            paginateMeta: {},
            isLoading: true,
            isError:false,
            errorMsg:'',
            searchTerm: '',
            content:'',
            files:null,
        }
    },
    methods: {
        getData: function(page = 1, search = '', filter = '') {
            this.isLoading = true;
            let queryString = `page=${page}&per_page=10&embed=commentor,media`;  
            if ( search != '' ) {
                queryString += `search=${search}`;
            }
            axios.get(`/api/unit_handovers/${this.id}/comments?${queryString}`)
            .then( response => {
                response.data.data.forEach( (obj) => {                   
                    this.items.push(obj);
                });
                this.paginateMeta = response.data.meta;              
            })
            .catch( error => {        
               console.log(error);
            })
            .finally( () => {
                this.isLoading = false;
            });
        },
        paginate: function (page) {           
            this.getData(page, this.searchTerm);
        },
        onKeyDown: function(event){
            if (this.content.length >= 250) {
                event.preventDefault()
                return;              
            }
        },
        handleInputChanged() {
            this.isError = false;
            this.errorMsg = '';
        },
        handleFileUpload() {
            this.isError = false;
            this.errorMsg = '';
            this.files = this.$refs.file.files;
        },
        onCommentFormSumbitted: function (event) {
            let formData = new FormData();
            formData.append('content', this.content);
            
            if ( this.files != null) {
                for( var i = 0; i < this.files.length; i++ ){
                    let file = this.files[i];
                    formData.append('media[]', file);
                }
            }

            axios.post( `/api/unit_handovers/${this.id}/comments`,
                formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then( response => {               
                this.items.unshift(response.data.data);
                this.content = '';
                this.files = null;
            })
            .catch( error => {
                this.isError = true;
                this.errorMsg = error.response.data.error.message ? error.response.data.error.message : error.message;
            });
        },      
    },
    mounted() { 
        if ( this.id ) {
            this.getData();
        }  
    }  
}
</script>
