<?php
namespace App\Lib;

class S3Helpers {
  /**
   * Get all the necessary details to directly upload a private file to S3
   * asynchronously with JavaScript using the Signature V4.
   *
   * @param string $s3Bucket your bucket's name on s3.
   * @param string $region   the bucket's location/region, see here for details: http://amzn.to/1FtPG6r
   * @param string $acl      the visibility/permissions of your file, see details: http://amzn.to/18s9Gv7
   *
   * @return array ['url', 'inputs'] the forms url to s3 and any inputs the form will need.
   */
  public static function getS3Details($s3Bucket = null, $region = null, $acl = 'private', $expirationDuration = 30) {

      // Options and Settings
      $awsKey = config('filesystems.disks.s3.key');
      $awsSecret = config('filesystems.disks.s3.secret');
      if (!$s3Bucket) $s3Bucket = config('filesystems.disks.s3.bucket');
      if (!$region) $region = config('filesystems.disks.s3.region');

      $algorithm = "AWS4-HMAC-SHA256";
      $service = "s3";
      $date = gmdate("Ymd\THis\Z");
      $shortDate = gmdate("Ymd");
      $requestType = "aws4_request";
      $expires = "86400"; // 24 Hours
      $successStatus = "201";
      $url = "//{$s3Bucket}.{$service}-{$region}.amazonaws.com";

      // Step 1: Generate the Scope
      $scope = [
          $awsKey,
          $shortDate,
          $region,
          $service,
          $requestType
      ];
      $credentials = implode('/', $scope);

      // Step 2: Making a Base64 Policy
      $policy = [
          'expiration' => gmdate('Y-m-d\TG:i:s\Z', strtotime('+'.$expirationDuration.' seconds')),
          'conditions' => [
              ['bucket' => $s3Bucket],
              ['acl' => $acl],
              ['starts-with', '$key', ''],
              ['starts-with', '$Content-Type', ''],
              ['success_action_status' => $successStatus],
              ['x-amz-credential' => $credentials],
              ['x-amz-algorithm' => $algorithm],
              ['x-amz-date' => $date],
              ['x-amz-expires' => $expires],
          ]
      ];
      $base64Policy = base64_encode(json_encode($policy));

      // Step 3: Signing your Request (Making a Signature)
      $dateKey = hash_hmac('sha256', $shortDate, 'AWS4' . $awsSecret, true);
      $dateRegionKey = hash_hmac('sha256', $region, $dateKey, true);
      $dateRegionServiceKey = hash_hmac('sha256', $service, $dateRegionKey, true);
      $signingKey = hash_hmac('sha256', $requestType, $dateRegionServiceKey, true);

      $signature = hash_hmac('sha256', $base64Policy, $signingKey);

      // Step 4: Build form inputs
      // This is the data that will get sent with the form to S3
      $inputs = [
          'Content-Type' => '',
          'acl' => $acl,
          'success_action_status' => $successStatus,
          'policy' => $base64Policy,
          'X-amz-credential' => $credentials,
          'X-amz-algorithm' => $algorithm,
          'X-amz-date' => $date,
          'X-amz-expires' => $expires,
          'X-amz-signature' => $signature
      ];

      return compact('url', 'inputs');
  }
}
