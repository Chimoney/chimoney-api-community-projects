import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NgxChimoneyAirtimePayoutsComponent } from './ngx-chimoney-airtime-payouts.component';

describe('NgxChimoneyAirtimePayoutsComponent', () => {
  let component: NgxChimoneyAirtimePayoutsComponent;
  let fixture: ComponentFixture<NgxChimoneyAirtimePayoutsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [NgxChimoneyAirtimePayoutsComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(NgxChimoneyAirtimePayoutsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
