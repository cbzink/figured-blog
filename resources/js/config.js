var api_url = "";

switch (process.env.NODE_ENV) {
    case "production":
        api_url = "http://figured-blog.test/api";
        break;

    default:
        api_url = "http://figured-blog.test/api";
        break;
}

export const APP_CONFIG = {
    API_URL: api_url
};
