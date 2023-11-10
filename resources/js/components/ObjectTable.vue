<template >
    <l-control class="control" position="topleft" >
            <div style="background-color: whitesmoke; height:100%;width:100% ">
                <label>Все объекты</label>
                <button @click="clickHandler">
                I am a useless button!
                </button>
                <div>
                    <label style="margin-right: 5px;">Поиск</label>
                    <input v-model="message" placeholder="" style="outline: 2px;">
                </div>
                <table class="table mt-5">
                <thead>
                <tr>
                <th scope="col"> </th>
                <th scope="col">#</th>
                <th scope="col">Название</th>
                <th scope="col"> </th>
                <th scope="col"> </th>
                <th scope="col"> </th>
                <th scope="col"> </th>

                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,idx) in arr_data">
                <td><input type="checkbox" id="checkbox" v-model="checked"></td>
                <th scope="row">{{item.id}}</th>
                <td>{{item.name}}</td>
                </tr>
                </tbody>
            </table>
            </div>
        </l-control>
</template>
<script>
export default {

}
</script>
<style lang="">

</style>
