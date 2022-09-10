<template>
    <header class="container-fluid">
        <ul class="ms-links">
            <li>
                <router-link
                    class="logo-container"
                    aria-current="page"
                    :to="{ name: 'home' }"
                >
                    <h4 class="pippo">Bool BnB</h4>
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
                <a class="btn ms-login" aria-current="page" href="/login"
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
    height: 60px;
    background-color: #de2547;
    position: fixed;
    z-index: 1;
    .pippo {
        padding: 0 2rem;
        line-height: 80px;
    }
    .pippo:hover {
        text-decoration: underline;
        // text-transform: uppercase;
        color: white;
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
    border-color: #ec2b00;
    background-color: #ec2b00;
}
.ms-register {
    color: black;
    border-color: white;
    background-color: white;
}
</style>
