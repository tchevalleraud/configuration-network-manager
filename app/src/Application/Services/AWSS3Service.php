<?php
    namespace App\Application\Services;

    use Aws\S3\S3Client;

    class AWSS3Service {

        private $endpoint;
        private $key;
        private $secret;
        private $client;

        private $policyReadOnly = '{"Version": "2012-10-17","Statement": [{"Action": ["s3:GetBucketLocation","s3:ListBucket"],"Effect": "Allow","Principal": {"AWS": ["*"]},"Resource": ["arn:aws:s3:::%s"],"Sid": ""},{"Action": ["s3:GetObject"],"Effect": "Allow","Principal": {"AWS": ["*"]},"Resource": ["arn:aws:s3:::%s/*"],"Sid": ""}]}';

        public function __construct(string $endpoint, string $key, string $secret){
            $this->endpoint = $endpoint;
            $this->key = $key;
            $this->secret = $secret;
            $this->client = new S3Client([
                'credentials'   => [
                    'key'       => $this->key,
                    'secret'    => $this->secret
                ],
                'endpoint'      => $this->endpoint,
                'region'        => 'us-east-1',
                'use_path_style_endpoint' => true,
                'version'       => 'latest'
            ]);
        }

        public function createBucket(string $name){
            $this->client->createBucket([
                'Bucket'    => $name
            ]);
            $this->client->putBucketPolicy([
                'Bucket'    => $name,
                'Policy'    => sprintf($this->policyReadOnly, $name, $name)
            ]);
        }

        public function deleteBucket(string $name){
            if($this->isExistBucket('tenant')){
                $objects = $this->client->listObjects(['Bucket' => 'tenant']);
                if($objects['Contents']){
                    foreach ($objects['Contents'] as $item){
                        $this->client->deleteObject([
                            'Bucket'    => $name,
                            'Key'       => $item['Key']
                        ]);
                    }
                }
                $this->client->deleteBucket([
                    'Bucket'    => $name
                ]);
            }
        }

        public function deleteObject(string $bucket, string $filename){
            $this->client->deleteObject([
                'Bucket'    => $bucket,
                'Key'       => $filename
            ]);
        }

        public function deleteObjectUpload(string $bucket, $url){
            $this->deleteObject($bucket, str_replace($this->endpoint.''.$bucket.'/', '', $url));
        }

        public function getObject(string $bucket, string $filename){
            return $this->client->getObject([
                'Bucket'    => $bucket,
                'Key'       => $filename
            ]);
        }

        public function getObjectUrl(string $bucket, string $filename){
            return $this->client->getObjectUrl($bucket, $filename);
        }

        public function putObject(string $bucket, string $filename, $data){
            $this->client->putObject([
                'Bucket'    => $bucket,
                'Key'       => $filename,
                'Body'      => $data
            ]);
        }

        public function putObjectUpload(string $bucket, $data){
            $filename = uniqid('', true).".".$data->guessExtension();
            $this->putObject($bucket, $filename, file_get_contents($data->getPathname()));
            return $this->getObjectUrl($bucket, $filename);
        }

        public function isExistBucket(string $bucket){
            $buckets = $this->client->listBuckets();
            foreach ($buckets['Buckets'] as $item){
                if($item['Name'] == $bucket) return true;
            }
            return false;
        }

    }