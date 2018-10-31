<template>
    <div>
        <pre><strong>Raymond Usbal</strong> &lt;raymond@philippinedev.com&gt;</pre>
        <div v-if="csv_download_link" class="alert alert-success" role="alert">
            <a :href="csv_download_link">CSV File</a> is ready to download.
        </div>
        <div class="row m-b-15">
            <div class="col-sm-12 text-right">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button @click="exportToCsv" type="button" class="btn btn-success" :class="{ disabled: csv_download_link }">Export To CSV</button>
                    <a v-if="csv_download_link" :href="csv_download_link" class="btn btn-secondary btn-danger">Download CSV</a>
                </div>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Number of Employees</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="company in companies">
                    <td>{{ company.id }}</td>
                    <td>{{ company.name }}</td>
                    <td>{{ company.employee_count }}</td>
                    <td>{{ company.created_date }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "list",
    data() {
        return {
            auth: {
                user: {
                    email: 'raymond@philippinedev.com',
                    password: 'secret'
                },
                token: null
            },
            companies: [],
            csv_download_link: null
        }
    },
    computed: {
        headers() {
            return {
                headers: { 'Authorization': "Bearer " + this.auth.token }
            }
        }
    },
    mounted() {
        this.login()
            .then(result => {
                this.auth.token = result.data.access_token
                this.loadCompanies()
            })
            .catch(err => this.alert(err))
    },
    methods: {
        alert(message) {
            console.log(message)
            alert(message)
        },
        login() {
            return axios.post('/api/auth/login', this.auth.user)
        },
        loadCompanies() {
            axios.get('/api/companies', this.headers)
                .then(result => {
                    this.companies = result.data
                })
                .catch(err => this.alert(err))
        },
        exportToCsv(evt) {
            evt.preventDefault()
            axios.post('/api/exports', [], this.headers)
                .then(result => {
                    console.log(result.data.csv_uri)
                    this.csv_download_link = result.data.csv_uri
                })
                .catch(err => this.alert(err))
        }
    }
}
</script>

<style scoped>
    .m-b-15 {
        margin-bottom: 15px;
    }
</style>