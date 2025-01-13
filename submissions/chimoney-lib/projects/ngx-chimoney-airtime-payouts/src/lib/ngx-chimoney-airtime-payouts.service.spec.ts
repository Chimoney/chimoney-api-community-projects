import { TestBed } from '@angular/core/testing';

import { NgxChimoneyAirtimePayoutsService } from './ngx-chimoney-airtime-payouts.service';

describe('NgxChimoneyAirtimePayoutsService', () => {
  let service: NgxChimoneyAirtimePayoutsService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(NgxChimoneyAirtimePayoutsService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
