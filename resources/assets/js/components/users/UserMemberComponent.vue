<template>
	<!-- About Me Box -->
	<div class="card card-primary">
		<div class="card-header">
			<span>{{ total }} Members</span>
		</div>
		<!-- /.card-header -->
		<div class="card-body p-0 member-component" >
			<div class="list-group">
				<div class="list-group-item d-flex flex-row p-2" v-for="member in members" v-if="members.length > 0">
					<div class="user-avatar-container">
						<img class="profile-user-img img-fluid rounded-circle"
							:src="member.avatar_url">	
					</div>
					<div class="user-infor-container" style="width:100%;">
						<h5 class="mb-0"><a :href="'/admin/users/'+member.id">{{ member.name }}</a></h5>
						<span class="text-muted d-block" v-if="member.roles[0].name"><small>{{ member.roles[0].name | SentenceCase }}</small></span>
						<ul class="list-inline my-0">
							<li class="list-inline-item"><i class="fas fa-phone-square mr-1"></i>{{ member.phone_number }}</li>
						</ul>
					</div>
				</div>
				<!-- /.card-body -->
                <infinite-loading @infinite="infiniteHandler">
                	<div slot="spinner" class="list-group-item list-group-item-action text-center">Loading...</div>
					<div slot="no-more" class="list-group-item list-group-item-action text-center">No more data</div>
					<div slot="no-results" class="list-group-item list-group-item-action text-center">No results data</div>
                </infinite-loading>
			</div>
			<!-- /.card -->
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->
</template>

<style lang="scss" scoped>
    .member-component {
        height: calc(100vh - 160px);
        overflow-y: scroll;
    }
</style>

<script>
    export default {
    	filters: {
	        formatPhoneNumber : (str) => {
	            //Filter only numbers from the input
	            let cleaned = ('' + str).replace(/\D/g, '');              
	            //Check if the input is of correct
	            let match = cleaned.match(/^(\d{3})(\d{3})(\d{3,4})$/);
	            if (match) {
	                return  match[1] + ' ' + match[2] + ' ' + match[3]
	            };              
	            return str;
	        },
	        formatMemberSince: (date) => {
	            return moment(date).format('MMM, YYYY');
	        },
			SentenceCase: (text) => {
				return (text.charAt(0).toUpperCase() + text.slice(1)).replace("_", " ");
			}
	    },
        data() {
            return {
                page: 1,             
                members: [],
                total: 0,
            };
        },
        props: [ 
            'userId'
        ],
        methods: {
            infiniteHandler :  function($state) {
                axios.get(`/api/users/${this.userId}/members`, {
                    params: {
                        page: this.page,
                        embed: 'roles'
                    },
                }).then(({ data }) => {
                    if (data.data.length) {
                        this.page += 1;                    
                        this.members.push(...data.data);  
                        this.total = data.meta.total;                  

                        $state.loaded();
                    } else {
                        $state.complete();
                    }
                });
            },
        },
    };
</script>
