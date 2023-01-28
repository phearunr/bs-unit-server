<template>
    <div class="user-card-container">                                 
        <div class="user-avatar-container">
            <img class="profile-user-img rounded-circle" :src="user.avatar_url">   
        </div>
        <div class="user-info-container" style="width:100%;">
            <h5 class="mb-0">{{ user.name }}</h5>
            <span class="text-muted d-block" style="line-height: 1;"><small>{{ user.roles ? user.roles[0].name : '' | userRole }}</small></span>
            <ul class="list-inline my-0">
                <li class="list-inline-item"><i class="fas fa-phone-square mr-1"></i> {{ user.phone_number | formatPhoneNumber }}</li>
                <li class="list-inline-item" v-if="user.email != null"><i class="fas fa-envelope mr-1"></i> {{ user.email }}</li>
                <li class="list-inline-item"><i class="fas" v-bind:class="[user.active ? 'fa-check-circle text-success' : 'fa-times-circle text-danger']"></i> Active</li>
                <li class="list-inline-item"><i class="fas" v-bind:class="[user.verified ? 'fa-check-circle text-success' : 'fa-times-circle text-danger']"></i> Verify</li>
            </ul> 
        </div>          
        <div class="user-attribute-container">
            <span class="attribute-label text-muted">{{ unitRequestStatistic.unit_hold_requests_count | pluralize('Hold') }}</span>
            <span class="attribute-value"><a href="#">{{ unitRequestStatistic.unit_hold_requests_count }}</a></span>
        </div>
        <div class="user-attribute-container">
            <span class="attribute-label text-muted">{{ unitRequestStatistic.unit_deposit_requests_count | pluralize('Deposit') }}</span>
            <span class="attribute-value"><a href="#">{{ unitRequestStatistic.unit_deposit_requests_count }}</a></span>
        </div>
        <div class="user-attribute-container">
            <span class="attribute-label text-muted">{{ unitRequestStatistic.unit_deposit_requests_count | pluralize('Contract') }}</span>
            <span class="attribute-value"><a href="#">{{ unitRequestStatistic.unit_contract_requests_count }}</a></span>
        </div>
    </div>
</template>

<style scoped>
.user-card-container {
    display: flex;
    width: 100%;
    background: #FFF;
    border: 1px solid #d0d0d0;
}
.user-card-container .user-info-container, .user-card-container .user-avatar-container {
    padding:10px;
}
.user-card-container .user-info-container {
    padding-left: 0px;
}
.user-card-container .user-avatar-container .profile-user-img {
    width: 60px;
}
.user-attribute-container {
    background: rgba(0,0,0,0.03);
    min-width: 80px;
    display: flex;
    flex-direction: column-reverse;
    align-items: center;
    justify-content: center;
    border-left: 1px dashed #ccc;
}
.user-attribute-container span {
    line-height: 1;
}
.user-attribute-container .attribute-value {
    font-size: 1.25rem;
    font-weight: bold;
}

</style>

<script>
    export default {        
        props: [   
            'userId'
        ],
        data : () => {
            return {
                user: {},
                unitRequestStatistic: {},
                isLoading: true,
                isError:false,            
            }
        },
        filters: {
            userRole: function (role_string) {
                let str = role_string.replace(/_/g, ' ');
                return str.charAt(0).toUpperCase() + str.slice(1);
            },
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
        },
        methods: {
            getData: function() {           
                this.isLoading = true;
                let queryString = `?embed=roles&statistic=true`;  
                axios.get(`/api/users/${this.userId}${queryString}`)
                .then( response => {
                    this.user = response.data.data;          
                })
                .catch( error => {     
                    this.isError =  false;
                    this.user = null;
                })
                .finally( () => {
                    this.isLoading = false;
                });
            },
            getUserUnitStatistic: function() {
                this.isLoading = true;           
                axios.get(`/api/users/${this.userId}/unitRequestStatistic`)
                .then( response => {
                    this.unitRequestStatistic = response.data.data;          
                })
                .catch( error => {     
                    this.isError =  false;
                    this.user = null;
                })
                .finally( () => {
                    this.isLoading = false;
                });
            }
        },
        mounted() {
            this.getData();
            this.getUserUnitStatistic();
        }
    };
</script>
