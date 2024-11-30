provider "aws" {
  region = "your_aws_region"
}

resource "aws_instance" "laravel_server" {
  ami           = "ami-XXXXXXXX"   // Specify your desired AMI ID
  instance_type = "t2.micro"      // Or choose the instance type you want
  key_name      = "your_key_pair_name"  // Change to your key pair name
  security_groups = ["your_security_group"]  // Attach your security group
  user_data = <<-EOF
              #!/bin/bash
              sudo yum update -y
              sudo yum install -y git

              git clone https://github.com/davymaish/harambee.git
              cd harambee
              cp .env.example .env  // Remember to update .env with your environment configurations

              sudo yum install -y php php-mbstring php-xml php-xmlrpc php-soap php-gd php-xml php-mysqlnd
              sudo yum install -y composer
              composer install --no-dev
              php artisan storage:link
              # rm -rf storage/app/public/*

              EOF
}

output "server_public_ip" {
  value = aws_instance.laravel_server.public_ip
}
