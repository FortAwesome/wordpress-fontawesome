import { __ } from "@wordpress/i18n";
import apiFetch from "@wordpress/api-fetch";

const ACCESS_TOKEN_REFRESH_THRESHOLD_SECONDS = 60;

function currentTimeUnixEpochSeconds() {
  return Math.floor(Date.now() / 1000);
}

export function prepareAccessTokenGetter(restApiNamespace) {
  let accessToken;
  let accessTokenExpiresAt;

  const shouldRefresh = () => {
    if (!accessToken) return true;
    if (!Number.isFinite(accessTokenExpiresAt)) return true;

    const remainingSeconds =
      accessTokenExpiresAt - currentTimeUnixEpochSeconds();

    return remainingSeconds <= ACCESS_TOKEN_REFRESH_THRESHOLD_SECONDS;
  };

  return async () => {
    if (!accessToken || !accessTokenExpiresAt || shouldRefresh()) {
      const accessTokenResponse = await apiFetch({
        path: `${restApiNamespace}/api/token`,
        method: "GET",
      });

      accessToken = accessTokenResponse?.access_token;
      accessTokenExpiresAt = accessTokenResponse?.expires_at;
    }

    if (!accessToken) {
      const error = __(
        "Font Awesome Icon Chooser could not get an access token from the WordPress server.",
        "font-awesome",
      );
      console.error(error);
      throw new Error(error);
    }

    return accessToken;
  };
}
