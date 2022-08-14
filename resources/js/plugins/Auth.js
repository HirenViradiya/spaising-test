import config from "../Common/config";
const environmentConfig = config["development"];

export const getBaseUrl = () => {
    const baseURL = environmentConfig.api_url;
    const port = environmentConfig.api_port;

    return [baseURL, port || null].filter((f) => f).join(":") + "/api/";
};

// unauthorized Request Handler
export const unauthorizedHandler = (error) => {
    console.log("unauthorizedHandler");
    console.log(error);
    if (error && error.message === "Network Error") {
        // window.alertify('error', 'Server is down for maintenance!');
    }
    if (error && error.statusCode === 500) {
        setTimeout(() => {
            alert(error.data.message);
        });
    }
    if (error && error.statusCode === 400) {
        setTimeout(() => {
            alert(error.message);
        });
        if (error && error.statusCode === 403) {
            //   localStorage.clear() // clear all thin/gs in local storage
            //   window.location = "/";
        }
    }
};
