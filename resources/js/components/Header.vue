<template>
    <header class="container-fluid">
        <ul class="ms-links">
            <li>
                <router-link
                    class="logo-container"
                    aria-current="page"
                    :to="{ name: 'home' }"
                >
                    <img
                        src="../../../public/storage/image/logo.png"
                        alt=""
                        srcset=""
                    />
                </router-link>
            </li>
            <!-- <li>
                <router-link
                    class="logo-container"
                    aria-current="page"
                    :to="{ name: 'home' }"
                >
                    <h4 class="pippo">Lista appartamenti</h4>
                </router-link>
            </li> -->
            <li class="ms-auto">
                <a class="btn ms-login mr-2" aria-current="page" href="/login"
                    >Login
                    <i class="fas fa-user"></i>
                </a>
                <a class="btn ms-register" aria-current="page" href="/register"
                    >Diventa un Host
                </a>
            </li>
        </ul>
    </header>
</template>

<script>
export default {
    name: "Header",
};
</script>
<style lang="scss" scoped>
header {
    width: 100%;
    height: 75px;
    background: rgba(248, 249, 250, 0.7);
    // background: linear-gradient(
    //     0deg,
    //     rgba(255, 255, 255, 1) 35%,
    //     rgb(201, 201, 201, 0.5) 100%
    // );
    position: fixed;
    z-index: 1;
    img {
        padding: 0 2rem;
        height: 80px;
    }
}
.ms-links {
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 60px;
}
.btn {
    padding: 0.1rem 1rem;
    font-weight: 600;
}
.ms-login {
    color: white;
    border-color: black;
    background-color: black;
}
.ms-register {
    color: white;
    border-color: #ff385c;
    background-color: #ff385c;
}
</style>
