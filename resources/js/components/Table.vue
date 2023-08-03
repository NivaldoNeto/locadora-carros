<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titulos" :key="key">{{ t }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="n in dados" :key="n.id">
                    <th scope="row">{{ n.id }}</th>
                    <td>{{ n.nome }}</td>
                    <td><img :src="'/storage/' + n.imagem"></td>
                </tr>
            </tbody>
        </table>


    </div>
</template>

<script>
    export default {
        props: ['dados']
    }
</script>
