export interface bankDetails {
  bankName: string;
  accountName: string;
  accountNumber: string;
  iban: string;
  bic: string;
  sortCode: string;
}

export interface socialLinks {
  linkedin?: string;
  github?: string;
  twitter?: string;
}

export interface activityFeed {
  type: string;
  description: string
  date: string
}