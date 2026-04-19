import { ComponentFixture, TestBed } from '@angular/core/testing';

import { StageDetails } from './stage-details';

describe('StageDetails', () => {
  let component: StageDetails;
  let fixture: ComponentFixture<StageDetails>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [StageDetails],
    }).compileComponents();

    fixture = TestBed.createComponent(StageDetails);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
