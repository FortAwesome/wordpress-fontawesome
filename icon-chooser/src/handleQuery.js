import apiFetch from "@wordpress/api-fetch";
import md5 from "blueimp-md5";
import { __ } from "@wordpress/i18n";
import * as queryCache from "../../admin/src/queryCache";
import { prepareAccessTokenGetter } from "./accessToken";

const prepareQueryHandler = (params) => {
  const restApiNamespace = params?.restApiNamespace;
  const usingKit = !!params?.kitToken;
  const getAccessToken = prepareAccessTokenGetter(restApiNamespace);

  return async (query, variables, options) => {
    try {
      const { faApiUrl, apiNonce, rootUrl } = params;

      const cacheKey = `icon-chooser-${md5(
        `${query}${JSON.stringify(variables)}`,
      )}`;

      const data = queryCache.get(cacheKey);

      if (data) {
        return data;
      }

      // If apiFetch is from wp.apiFetch, it may already have RootURLMiddleware set up.
      // If we're using the fallback (i.e. when running in the Classic Editor), then
      // it doesn't yet have thr RootURLMiddleware.
      // We want to guarantee that it's there, so we'll always add it.
      // So what if it was already there? Experiment seems to have shown that this
      // is idempotent. It doesn't seem to hurt to just do it again, so we will.
      apiFetch.use(apiFetch.createRootURLMiddleware(rootUrl));

      // We need the nonce to be set up because we're going to run our query through
      // the API controller end point, which requires non-public authorization.
      apiFetch.use(apiFetch.createNonceMiddleware(apiNonce));

      const headers = {
        "content-type": "application/json",
      };

      if (usingKit) {
        const accessToken = await getAccessToken();
        headers.authorization = `Bearer ${accessToken}`;
      }

      const response = await fetch(faApiUrl, {
        method: "POST",
        headers,
        body: JSON.stringify({ query: query.replace(/\s+/g, " "), variables }),
      });

      if (!response.ok) {
        const error = __(
          "Font Awesome Icon Chooser received an error response from the Font Awesome API server. See developer console.",
          "font-awesome",
        );
        console.error(error);
        throw new Error(error);
      }

      const responseBody = await response.json();
      const hasErrors =
        Array.isArray(responseBody?.errors) && responseBody.errors.length > 0;

      if (options?.cache && !hasErrors) {
        queryCache.set(cacheKey, responseBody);
      }

      return responseBody;
    } catch (error) {
      console.error("CAUGHT:", error);
      throw new Error(error);
    }
  };
};

export default prepareQueryHandler;
