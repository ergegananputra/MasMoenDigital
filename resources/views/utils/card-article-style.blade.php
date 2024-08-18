<style>
    .article a.card-clickable-body{
        text-decoration: none;
        color: rgb(29, 27, 27);
    }
    .article .img-container {
        width: 100%;
        aspect-ratio: 11/10;

        transition: 0.3s ease-in-out;

        /* clip */
        overflow: hidden;
        
        transition: 0.3s ease-in-out;

        position: relative;
    }

    .article .badge-top-right {
        position: absolute;
        top: 16px; /* Adjust as needed */
        right: 16px; /* Adjust as needed */
        z-index: 1; /* Ensure the badge is above the image */

        background-color: rgba(87, 33, 204, 0.8) !important; /* Semi-transparent background */
        backdrop-filter: blur(10px); /* Blur effect */
        -webkit-backdrop-filter: blur(10px); /* For Safari */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .article .img-container h5 {
        margin: 0; /* Remove default margin */
        padding: 0; /* Remove default padding */
    }

    .article .img-container .badge {
        margin: 0; /* Remove default margin */
        padding: 0.5em; /* Adjust padding as needed */
    }

    .article .img-container img {
        transition: 0.3s ease-in-out;
        object-fit: cover;
        width: 100%; /* Ensures the image fills the width of the container */
        height: 100%; /* Ensures the image fills the height of the container */
    }

    .article .img-container img:hover {
        transform: scale(1.15);
        transition: 0.8s ease-in-out;
    }

    .article .card-title,.article .card-text {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card.article {
        position: relative; /* Ensure the card is positioned relative for the pseudo-element */
        outline: none;
        border: none;
        transition: 0.3s ease-in-out;
        box-shadow: 12px 12px 12px rgba(76, 73, 73, 0.1), 
            -10px -10px 10px rgba(255, 255, 255, 0.8); 
    }
</style>