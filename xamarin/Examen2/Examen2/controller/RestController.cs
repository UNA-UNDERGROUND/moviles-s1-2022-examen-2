using System;
using System.Text;
using System.Net;
using System.Threading.Tasks;

namespace Examen2.controller
{
    // this class is used to handle the REST calls
    // it allows an optional body to be sent with the request
    // that body is a JSON string
    // the response can be empty, a JSON string
    // and allow the following verbs: GET, POST, PUT, DELETE
    public class RestController
    {
        public string verb { get; set; }
        public string body { get; set; }

        public RestController(string verb, string body)
        {
            this.verb = verb;
            this.body = body;
        }

        // async request to the server (async method [Response])
        public async Task<Response> doRequest()
        {
            Response response = new Response();
            try
            {
                // create the httpclient
                var httpClient = new System.Net.Http.HttpClient();
                // create the request
                var request = new System.Net.Http.HttpRequestMessage();
                // set the verb
                request.Method = new System.Net.Http.HttpMethod(verb);
                // set the body
                if (body != null)
                {
                    request.Content = new System.Net.Http.StringContent(body, Encoding.UTF8, "application/json");
                }
                // send the request
                var result = await httpClient.SendAsync(request);
                // try to cast to a JSON string
                var code = result.StatusCode;
                var responseBody = await result.Content.ReadAsStringAsync();
            }
            catch (Exception e)
            {
                response.body = e.Message;
                // cast to an integer to get the status code
                response.statusCode = System.Net.HttpStatusCode.InternalServerError;
            }
            return response;
        }


        // static async methods for the different verbs
        // for get and delete, the body is not used
        // for post and put, the body is a JSON string
        public static async Task<Response> get(string url)
        {
            return await new RestController("GET", null).doRequest();
        }
        public static async Task<Response> post(string url, string body)
        {
            return await new RestController("POST", body).doRequest();
        }
        public static async Task<Response> put(string url, string body)
        {
            return await new RestController("PUT", body).doRequest();
        }
        public static async Task<Response> delete(string url)
        {
            return await new RestController("DELETE", null).doRequest();
        }

        // the response class
        // it contains the response body and the response code
        public class Response
        {
            public string body { get; set; }
            public HttpStatusCode statusCode { get; set; }
        }
    }
}
