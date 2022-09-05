<template>
    <div class="container">
        <div id="mapContainer">
            <img
                :src="`https://api.tomtom.com/map/1/staticimage?key=tK1dfG1bbj4Bwrg4EHPfImXRSLMFlytw&center=${this.center}&zoom=16&width=900`"
                alt=""
            />
            <i class="fas fa-map-marker-alt"></i>
        </div>
    </div>
</template>

<script>
export default {
    name: "Map",
    props: {
        accomodation: Object,
    },
    data() {
        return {
            center: [
                this.accomodation.longitude + "," + this.accomodation.latitude,
            ],
        };
    },
};
</script>

<style lang="scss" scoped>
#mapContainer {
    margin: 2rem auto;
    position: relative;
    img {
        border-radius: 20px;
        width: 100%;
        height: 100%;
    }
    i {
        font-size: 2rem;
        color: #d63b33;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
}
</style>
