<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
            
                <!-- inicio do card de busca -->
                <card-component titulo="Busca de marcas">
                    <template v-slot:conteudo>
                        <div class="row g-3" >
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID do registro!">
                                    <input type="number" class="form-control" id="inputID" aria-describedby="idlHelp" placdeholder="ID">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome da marca!">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placdeholder="Nome da Marca">
                                </input-container-component>
                            </div> 
                        </div>
                    </template>
                    
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right">Pesquisar</button>
                    </template>
                </card-component>
                <!-- fim do card de busca -->
                
                <!-- fim do card de listagem de marcas -->
                <card-component titulo="Relação de Marcas">
                    <template v-slot:conteudo> 
                        <table-component 
                            :dados="marcas"
                            :titulos="['ID', 'Nome', 'Imagem']"></table-component>
                    </template>

                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#marcaModal">Adicionar</button>
                    </template>
                </card-component>
                <!-- fim do card de listagem de marcas -->
            </div>
        </div>
        <modal-component id="marcaModal" titulo="Adiciona Marca">
            <template v-slot:alertas>
                <alert-component tipo="sucess" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastras marca!" v-if="transacaoStatus ==  'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome da marca" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome da marca!">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placdeholder="Nome da Marca" v-model="nomeMarca">
                    </input-container-component>
                    {{ nomeMarca }}
                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="nonoImagem" id-help="novoImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG!">
                        <input type="file" class="form-control" id="nonoImagem" aria-describedby="novoImagemHelp" placdeholder="Selecione uma Imagem" @change="carregarImagem($event)">
                    </input-container-component>
                    {{ arquivoImagem }}
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Save changes</button>
            </template>
        </modal-component>

        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                urlBase:'http://localhost:8000/api/v1/marca',
                nomeMarca: '',
                arquivoImagem: [],
                transacaoStatus:'',
                transacaoDetalhes:[],
                marcas: []
            }
        },
        methods: {
            carregarLista() {
                axios.get(this.urlBase)
                .then(response => {
                    this.marcas = response.data
                    console.log(this.marcas)
                })
                .catch(errors => {
                    console.log(errors)
                })
            },
            carregarImagem(e) {
                this.arquivoImagem = e.target.files
            },
            salvar() {
                console.log(this.nomeMarca, this.arquivoImagem[0])

                let formData = new  FormData();
                formData.append('nome', this.nomeMarca)
                formData.append('imagem', this.arquivoImagem)

                let config = {
                    headers: {
                        'Contet-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                        'Authorization':'Bearer TOKEN'
                    }
                }

                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        this.transacaoStatus = 'adicionado'
                        this.transacaoDetalhes = response
                        console.log(response)
                    })
                    .catch(errors => {
                        this.transacaoStatus = 'erro'
                        this.transacaoDetalhes = errors.response
                        //console.log(data.message)
                    })
            },
            mounted() {
                this.carregarLista()
            }
        }
    }
</script>
