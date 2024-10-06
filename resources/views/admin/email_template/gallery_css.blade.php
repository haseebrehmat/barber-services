<style>
    .edit-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
    }

    .card-container {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 300px;
    }

    .card-container img {
        transition: filter 0.1s ease;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-container:hover .edit-button {
        display: block;
    }

    .card-container:hover img {
        filter: blur(3px);
    }

    .bn632-hover {
        width: fit-content;
        padding-inline: 30px;
        font-size: 16px;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        height: 40px;
        text-align: center;
        border: none;
        background-size: 300% 100%;
        border-radius: 50px;
        moz-transition: all .4s ease-in-out;
        -o-transition: all .4s ease-in-out;
        -webkit-transition: all .4s ease-in-out;
        transition: all .4s ease-in-out;
    }

    .bn632-hover:hover {
        background-position: 100% 0;
        moz-transition: all .4s ease-in-out;
        -o-transition: all .4s ease-in-out;
        -webkit-transition: all .4s ease-in-out;
        transition: all .4s ease-in-out;
    }

    .bn632-hover:focus {
        outline: none;
    }

    .bn632-hover.bn22 {
        background-image: linear-gradient(to right,
                #0ba360,
                #3cba92,
                #30dd8a,
                #2bb673);
        box-shadow: 0 4px 15px 0 rgba(23, 168, 108, 0.75);
    }
</style>
