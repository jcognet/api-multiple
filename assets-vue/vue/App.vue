<template>
    <div class="main">
        <h2>This is vue ! :)</h2>
        <div class="form">
            <div>
                <label for="keyword">Mot clé</label>
                <input
                    :disabled="isLoading"
                    type="text"
                    v-model="keyword"
                    name="keyword"
                    id="keyword" />
            </div>
            <div>
                <input
                    :disabled="isLoading"
                    type="button"
                    @click.prevent="handleOnClick"
                    value="lancer la recherche >" />
            </div>
        </div>
        <h2>Debug</h2>
        Breweries size : {{ breweries.length }}
        <table v-if="breweries.length > 0">
            <tr v-for="(brewery, index) in breweries" :key="`breweries_${index}`">
                <td>{{ brewery.name }}</td>
                <td>{{ brewery.country }}</td>
                <td>{{ brewery.type }}</td>
                <td>
                    <template v-if="brewery.url">
                        <a :href="brewery.url" target="_blank">{{ brewery.url }}</a>
                    </template>
                </td>
                <td>{{ brewery.origin }}</td>
            </tr>
        </table>
        <div v-else>Nothing yet !</div>
    </div>
</template>

<script>
export default {
    name: 'app',
    data: () => ({
        ws: new WebSocket(`ws://localhost:${process.env.WEBSOCKET_PORT}`),
        breweries: [],
        keyword: 'lef',
        isLoading: true
    }),
    mounted() {
        this.ws.addEventListener('open', this.handleOpenConnection);
        this.ws.addEventListener('message', this.handleOnMessage);
    },
    methods: {
        callApi(keyword) {
            this.breweries = [];
            this.ws.send(JSON.stringify({ keyword: keyword }));
        },
        handleOnClick() {
            this.isLoading = true;
            this.callApi(this.keyword);
        },
        handleOnMessage(e) {
            console.log('event', e.data);
            JSON.parse(e.data).map((brewery) => {
                this.breweries.push(brewery);
            });
            this.isLoading = false;
        },
        handleOpenConnection() {
            this.isLoading = false;
        }
    },
};
</script>

<style lang="scss" scoped>
.main {
    color: #718c00;
}
.form {
    display: flex;
    div {
        margin-right: 10px;
    }
}
</style>
